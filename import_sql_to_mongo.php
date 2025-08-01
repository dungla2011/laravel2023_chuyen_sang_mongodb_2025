<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SqlToMongoImporter
{
    private $sqlContent;
    private $stats = [];
    
    public function __construct($sqlFilePath)
    {
        if (!file_exists($sqlFilePath)) {
            throw new Exception("SQL file not found: $sqlFilePath");
        }
        
        $this->sqlContent = file_get_contents($sqlFilePath);
        echo "📁 Loaded SQL file: " . basename($sqlFilePath) . "\n";
        echo "📊 File size: " . number_format(strlen($this->sqlContent)) . " bytes\n\n";
    }
    
    public function import($databaseName = 'test_2025')
    {
        // Set database
        config(['database.connections.mongodb.database' => $databaseName]);
        DB::purge('mongodb');
        
        echo "🎯 Target database: $databaseName\n";
        echo "🚀 Starting import...\n\n";
        
        // Parse and import tables
        $this->parseAndImportTables();
        
        // Show statistics
        $this->showStatistics();
    }
    
    private function parseAndImportTables()
    {
        // Split SQL into statements
        $statements = preg_split('/;\s*\n/', $this->sqlContent);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement)) continue;
            
            // Handle CREATE TABLE
            if (preg_match('/CREATE TABLE `([^`]+)`/', $statement, $matches)) {
                $tableName = $matches[1];
                echo "📋 Found table: $tableName\n";
                $this->stats[$tableName] = ['created' => true, 'records' => 0];
            }
            
            // Handle INSERT INTO
            if (preg_match('/INSERT INTO `([^`]+)`\s*\(([^)]+)\)\s*VALUES/i', $statement, $matches)) {
                $tableName = $matches[1];
                $columns = $this->parseColumns($matches[2]);
                $records = $this->parseInsertValues($statement);
                
                echo "📥 Importing data to collection: $tableName\n";
                echo "   Columns: " . implode(', ', $columns) . "\n";
                echo "   Records: " . count($records) . "\n";
                
                $this->importRecords($tableName, $columns, $records);
                
                if (!isset($this->stats[$tableName])) {
                    $this->stats[$tableName] = ['created' => false, 'records' => 0];
                }
                $this->stats[$tableName]['records'] += count($records);
                echo "   ✅ Imported successfully\n\n";
            }
        }
    }
    
    private function parseColumns($columnString)
    {
        $columns = array_map('trim', explode(',', $columnString));
        return array_map(function($col) {
            return trim($col, '`');
        }, $columns);
    }
    
    private function parseInsertValues($statement)
    {
        // Extract VALUES part
        preg_match('/VALUES\s*(.+)$/si', $statement, $matches);
        if (!$matches) return [];
        
        $valuesString = $matches[1];
        
        // Parse multiple value sets
        $records = [];
        $currentPos = 0;
        $length = strlen($valuesString);
        
        while ($currentPos < $length) {
            if ($valuesString[$currentPos] === '(') {
                $record = $this->parseValueSet($valuesString, $currentPos);
                if ($record !== null) {
                    $records[] = $record;
                }
            }
            $currentPos++;
        }
        
        return $records;
    }
    
    private function parseValueSet($string, &$pos)
    {
        if ($string[$pos] !== '(') return null;
        
        $pos++; // Skip opening parenthesis
        $values = [];
        $currentValue = '';
        $inQuotes = false;
        $quoteChar = '';
        $depth = 0;
        
        while ($pos < strlen($string)) {
            $char = $string[$pos];
            
            if (!$inQuotes && ($char === "'" || $char === '"')) {
                $inQuotes = true;
                $quoteChar = $char;
                $currentValue .= $char;
            } elseif ($inQuotes && $char === $quoteChar) {
                // Check if it's escaped
                if ($pos > 0 && $string[$pos - 1] === '\\') {
                    $currentValue .= $char;
                } else {
                    $inQuotes = false;
                    $currentValue .= $char;
                }
            } elseif (!$inQuotes) {
                if ($char === '(') {
                    $depth++;
                    $currentValue .= $char;
                } elseif ($char === ')') {
                    if ($depth > 0) {
                        $depth--;
                        $currentValue .= $char;
                    } else {
                        // End of this value set
                        if (trim($currentValue) !== '') {
                            $values[] = $this->parseValue(trim($currentValue));
                        }
                        $pos++;
                        return $values;
                    }
                } elseif ($char === ',') {
                    $values[] = $this->parseValue(trim($currentValue));
                    $currentValue = '';
                } else {
                    $currentValue .= $char;
                }
            } else {
                $currentValue .= $char;
            }
            
            $pos++;
        }
        
        return $values;
    }
    
    private function parseValue($value)
    {
        $value = trim($value);
        
        // NULL
        if (strtoupper($value) === 'NULL') {
            return null;
        }
        
        // String values (quoted)
        if ((substr($value, 0, 1) === "'" && substr($value, -1) === "'") ||
            (substr($value, 0, 1) === '"' && substr($value, -1) === '"')) {
            $unquoted = substr($value, 1, -1);
            // Unescape quotes
            $unquoted = str_replace(["\\'", '\\"', '\\\\'], ["'", '"', '\\'], $unquoted);
            
            // Try to parse as date
            if (preg_match('/^\d{4}-\d{2}-\d{2}(\s\d{2}:\d{2}:\d{2})?$/', $unquoted)) {
                try {
                    return Carbon::parse($unquoted);
                } catch (Exception $e) {
                    return $unquoted;
                }
            }
            
            return $unquoted;
        }
        
        // Numeric values
        if (is_numeric($value)) {
            if (strpos($value, '.') !== false) {
                return floatval($value);
            } else {
                return intval($value);
            }
        }
        
        return $value;
    }
    
    private function importRecords($tableName, $columns, $records)
    {
        $collection = DB::connection('mongodb')->table($tableName);
        
        // Clear existing data
        $collection->truncate();
        
        $documents = [];
        foreach ($records as $record) {
            $document = [];
            for ($i = 0; $i < count($columns) && $i < count($record); $i++) {
                $column = $columns[$i];
                $value = $record[$i];
                
                // Handle special MongoDB fields
                if ($column === 'id') {
                    // Keep original ID as separate field and let MongoDB generate _id
                    $document['original_id'] = $value;
                } else {
                    $document[$column] = $value;
                }
            }
            
            // Add timestamps if not present
            if (!isset($document['created_at'])) {
                $document['created_at'] = Carbon::now();
            }
            if (!isset($document['updated_at'])) {
                $document['updated_at'] = Carbon::now();
            }
            
            $documents[] = $document;
        }
        
        if (!empty($documents)) {
            $collection->insert($documents);
        }
    }
    
    private function showStatistics()
    {
        echo "📊 IMPORT STATISTICS\n";
        echo str_repeat("=", 50) . "\n";
        
        $totalTables = 0;
        $totalRecords = 0;
        
        foreach ($this->stats as $tableName => $stats) {
            $totalTables++;
            $totalRecords += $stats['records'];
            
            echo sprintf("📋 %-25s: %5d records\n", $tableName, $stats['records']);
        }
        
        echo str_repeat("-", 50) . "\n";
        echo sprintf("📊 %-25s: %5d tables\n", "TOTAL TABLES", $totalTables);
        echo sprintf("📊 %-25s: %5d records\n", "TOTAL RECORDS", $totalRecords);
        echo str_repeat("=", 50) . "\n";
        echo "✅ Import completed successfully!\n";
    }
}

// Main execution
try {
    $sqlFile = __DIR__ . '/database/glx_for_import_mongo.sql';
    $importer = new SqlToMongoImporter($sqlFile);
    
    // Import to test_2025 database (for web)
    echo "🎯 Importing to test_2025 database (web)...\n";
    $importer->import('test_2025');
    
    echo "\n" . str_repeat("=", 60) . "\n";
    
    // Import to glx2023_for_testing database (for CLI)
    echo "🎯 Importing to glx2023_for_testing database (CLI)...\n";
    $importer->import('glx2023_for_testing');
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
