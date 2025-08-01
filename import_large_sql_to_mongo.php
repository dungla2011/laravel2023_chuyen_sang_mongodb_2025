<?php

/*
 * Script import file SQL vào MongoDB
 * Sử dụng cho file: glx_for_import_mongo.sql
 * 
 * Usage: php import_large_sql_to_mongo.php
 */

require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LargeSqlToMongoImporter
{
    private $importedTables = [];
    private $totalInserted = 0;
    private $errors = [];
    
    public function __construct()
    {
        echo "=== IMPORT SQL FILE TO MONGODB ===\n";
        echo "Initializing MongoDB connection...\n";
        
        // Test connection
        try {
            DB::connection('mongodb')->table('test_connection')->count();
            echo "✓ MongoDB connection successful\n";
        } catch (Exception $e) {
            die("✗ MongoDB connection failed: " . $e->getMessage() . "\n");
        }
    }
    
    public function importFromFile($filePath)
    {
        if (!file_exists($filePath)) {
            die("✗ File not found: $filePath\n");
        }
        
        echo "Reading SQL file: $filePath\n";
        $content = file_get_contents($filePath);
        
        if (empty($content)) {
            die("✗ File is empty or cannot be read\n");
        }
        
        echo "File size: " . number_format(strlen($content)) . " bytes\n";
        echo "Processing SQL statements...\n\n";
        
        $this->parseAndImportTables($content);
        $this->showSummary();
    }
    
    private function parseAndImportTables($content)
    {
        // Remove comments and normalize
        $content = preg_replace('/--.*$/m', '', $content);
        $content = preg_replace('/\/\*.*?\*\//s', '', $content);
        
        // Split by statements
        $statements = explode(';', $content);
        
        $currentTable = null;
        $currentColumns = [];
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement)) continue;
            
            // CREATE TABLE
            if (preg_match('/CREATE\s+TABLE\s+`?(\w+)`?\s*\(/i', $statement, $matches)) {
                $currentTable = $matches[1];
                $currentColumns = $this->parseCreateTable($statement);
                echo "Found table: $currentTable with " . count($currentColumns) . " columns\n";
                continue;
            }
            
            // INSERT INTO
            if (preg_match('/INSERT\s+INTO\s+`?(\w+)`?\s*\(/i', $statement, $matches)) {
                $tableName = $matches[1];
                
                if ($tableName !== $currentTable) {
                    // Different table, parse columns again
                    $currentTable = $tableName;
                    echo "Switching to table: $currentTable\n";
                }
                
                $this->processInsertStatement($statement, $tableName, $currentColumns);
            }
        }
    }
    
    private function parseCreateTable($createStatement)
    {
        $columns = [];
        
        // Extract column definitions
        if (preg_match('/\((.*)\)/s', $createStatement, $matches)) {
            $columnDefs = $matches[1];
            
            // Split by commas, but respect parentheses
            $parts = $this->splitByCommaIgnoringParentheses($columnDefs);
            
            foreach ($parts as $part) {
                $part = trim($part);
                
                // Skip constraints
                if (preg_match('/^(PRIMARY\s+KEY|KEY|UNIQUE|INDEX|CONSTRAINT)/i', $part)) {
                    continue;
                }
                
                // Extract column name and type
                if (preg_match('/^`?(\w+)`?\s+(\w+)/i', $part, $matches)) {
                    $columnName = $matches[1];
                    $columnType = strtolower($matches[2]);
                    $columns[$columnName] = $columnType;
                }
            }
        }
        
        return $columns;
    }
    
    private function splitByCommaIgnoringParentheses($str)
    {
        $parts = [];
        $current = '';
        $parentheses = 0;
        
        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];
            
            if ($char === '(') {
                $parentheses++;
            } elseif ($char === ')') {
                $parentheses--;
            } elseif ($char === ',' && $parentheses === 0) {
                $parts[] = $current;
                $current = '';
                continue;
            }
            
            $current .= $char;
        }
        
        if (!empty($current)) {
            $parts[] = $current;
        }
        
        return $parts;
    }
    
    private function processInsertStatement($statement, $tableName, $columns)
    {
        try {
            // Extract columns and values
            if (preg_match('/INSERT\s+INTO\s+`?\w+`?\s*\((.*?)\)\s*VALUES\s*(.+)/is', $statement, $matches)) {
                $columnsPart = $matches[1];
                $valuesPart = $matches[2];
                
                // Parse column names
                $columnNames = array_map(function($col) {
                    return trim($col, '` ');
                }, explode(',', $columnsPart));
                
                // Parse values (can be multiple rows)
                $allValues = $this->parseInsertValues($valuesPart);
                
                $insertedCount = 0;
                foreach ($allValues as $values) {
                    if (count($values) === count($columnNames)) {
                        $document = $this->createDocument($columnNames, $values, $columns);
                        
                        // Insert to MongoDB
                        DB::connection('mongodb')->table($tableName)->insert($document);
                        $insertedCount++;
                    }
                }
                
                if ($insertedCount > 0) {
                    if (!isset($this->importedTables[$tableName])) {
                        $this->importedTables[$tableName] = 0;
                    }
                    $this->importedTables[$tableName] += $insertedCount;
                    $this->totalInserted += $insertedCount;
                    
                    echo "  → Inserted $insertedCount records into $tableName\n";
                }
            }
            
        } catch (Exception $e) {
            $this->errors[] = "Error in table $tableName: " . $e->getMessage();
            echo "  ✗ Error: " . $e->getMessage() . "\n";
        }
    }
    
    private function parseInsertValues($valuesPart)
    {
        $allValues = [];
        $valuesPart = trim($valuesPart);
        
        // Remove trailing semicolon
        $valuesPart = rtrim($valuesPart, ';');
        
        // Split by ),( for multiple rows
        $rows = preg_split('/\),\s*\(/', $valuesPart);
        
        foreach ($rows as $i => $row) {
            // Clean up parentheses
            $row = trim($row, '() ');
            
            $values = [];
            $current = '';
            $inQuotes = false;
            $quoteChar = null;
            $parentheses = 0;
            
            for ($j = 0; $j < strlen($row); $j++) {
                $char = $row[$j];
                $nextChar = ($j + 1 < strlen($row)) ? $row[$j + 1] : null;
                
                if (!$inQuotes && ($char === "'" || $char === '"')) {
                    $inQuotes = true;
                    $quoteChar = $char;
                } elseif ($inQuotes && $char === $quoteChar) {
                    // Check for escaped quote
                    if ($nextChar === $quoteChar) {
                        $current .= $char . $nextChar;
                        $j++; // Skip next char
                        continue;
                    } else {
                        $inQuotes = false;
                        $quoteChar = null;
                    }
                } elseif (!$inQuotes && $char === '(') {
                    $parentheses++;
                } elseif (!$inQuotes && $char === ')') {
                    $parentheses--;
                } elseif (!$inQuotes && $char === ',' && $parentheses === 0) {
                    $values[] = $this->parseValue(trim($current));
                    $current = '';
                    continue;
                }
                
                $current .= $char;
            }
            
            if (!empty($current)) {
                $values[] = $this->parseValue(trim($current));
            }
            
            $allValues[] = $values;
        }
        
        return $allValues;
    }
    
    private function parseValue($value)
    {
        $value = trim($value);
        
        // NULL
        if (strtoupper($value) === 'NULL') {
            return null;
        }
        
        // Quoted strings
        if ((str_starts_with($value, "'") && str_ends_with($value, "'")) ||
            (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
            $unquoted = substr($value, 1, -1);
            // Unescape quotes
            $unquoted = str_replace(["''", '""'], ["'", '"'], $unquoted);
            return $unquoted;
        }
        
        // Numbers
        if (is_numeric($value)) {
            return str_contains($value, '.') ? (float)$value : (int)$value;
        }
        
        // Functions/expressions - return as string
        return $value;
    }
    
    private function createDocument($columnNames, $values, $columnTypes)
    {
        $document = [];
        
        for ($i = 0; $i < count($columnNames); $i++) {
            $columnName = $columnNames[$i];
            $value = $values[$i] ?? null;
            $type = $columnTypes[$columnName] ?? 'varchar';
            
            // Convert based on type
            if ($value !== null) {
                switch ($type) {
                    case 'datetime':
                    case 'timestamp':
                        if ($value !== '0000-00-00 00:00:00') {
                            try {
                                $document[$columnName] = Carbon::parse($value)->toISOString();
                            } catch (Exception $e) {
                                $document[$columnName] = $value;
                            }
                        } else {
                            $document[$columnName] = null;
                        }
                        break;
                    
                    case 'date':
                        if ($value !== '0000-00-00') {
                            try {
                                $document[$columnName] = Carbon::parse($value)->format('Y-m-d');
                            } catch (Exception $e) {
                                $document[$columnName] = $value;
                            }
                        } else {
                            $document[$columnName] = null;
                        }
                        break;
                    
                    case 'int':
                    case 'bigint':
                    case 'tinyint':
                    case 'smallint':
                    case 'mediumint':
                        $document[$columnName] = (int)$value;
                        break;
                    
                    case 'decimal':
                    case 'float':
                    case 'double':
                        $document[$columnName] = (float)$value;
                        break;
                    
                    case 'tinyint(1)':
                        $document[$columnName] = (bool)$value;
                        break;
                    
                    default:
                        $document[$columnName] = $value;
                }
            } else {
                $document[$columnName] = null;
            }
        }
        
        return $document;
    }
    
    private function showSummary()
    {
        echo "\n=== IMPORT SUMMARY ===\n";
        echo "Total records imported: " . number_format($this->totalInserted) . "\n";
        echo "Tables imported: " . count($this->importedTables) . "\n\n";
        
        if (!empty($this->importedTables)) {
            echo "Details by table:\n";
            foreach ($this->importedTables as $table => $count) {
                echo "  - $table: " . number_format($count) . " records\n";
            }
        }
        
        if (!empty($this->errors)) {
            echo "\nErrors encountered:\n";
            foreach ($this->errors as $error) {
                echo "  ✗ $error\n";
            }
        }
        
        echo "\n=== VERIFICATION ===\n";
        foreach (array_keys($this->importedTables) as $tableName) {
            $count = DB::connection('mongodb')->table($tableName)->count();
            echo "MongoDB collection '$tableName': $count documents\n";
        }
        
        echo "\nImport completed!\n";
    }
}

// Run import
$importer = new LargeSqlToMongoImporter();
$importer->importFromFile(__DIR__ . '/glx_for_import_mongo.sql');
