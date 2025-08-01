<?php

/*
 * Script import file SQL vào MongoDB - Laravel Artisan Command
 * Sử dụng: php artisan tinker
 * Hoặc tạo custom command
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SimpleSqlImporter 
{
    public static function run($sqlFile)
    {
        echo "=== IMPORT SQL TO MONGODB ===\n";
        
        if (!file_exists($sqlFile)) {
            die("File not found: $sqlFile\n");
        }
        
        $content = file_get_contents($sqlFile);
        echo "File loaded: " . number_format(strlen($content)) . " bytes\n";
        
        // Parse simple INSERT statements
        $pattern = '/INSERT\s+INTO\s+`?(\w+)`?\s*\((.*?)\)\s*VALUES\s*\((.*?)\);/i';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
        
        $totalInserted = 0;
        $tables = [];
        
        foreach ($matches as $match) {
            $tableName = $match[1];
            $columns = array_map('trim', explode(',', $match[2]));
            $values = self::parseValues($match[3]);
            
            // Clean column names
            $columns = array_map(function($col) {
                return trim($col, '` ');
            }, $columns);
            
            if (count($columns) === count($values)) {
                $document = array_combine($columns, $values);
                
                // Add timestamp if not exists
                if (!isset($document['created_at'])) {
                    $document['created_at'] = Carbon::now()->toISOString();
                }
                if (!isset($document['updated_at'])) {
                    $document['updated_at'] = Carbon::now()->toISOString();
                }
                
                try {
                    DB::connection('mongodb')->table($tableName)->insert($document);
                    $totalInserted++;
                    
                    if (!isset($tables[$tableName])) {
                        $tables[$tableName] = 0;
                    }
                    $tables[$tableName]++;
                    
                    echo "✓ Inserted into $tableName\n";
                    
                } catch (Exception $e) {
                    echo "✗ Error in $tableName: " . $e->getMessage() . "\n";
                }
            }
        }
        
        echo "\n=== SUMMARY ===\n";
        echo "Total inserted: $totalInserted\n";
        foreach ($tables as $table => $count) {
            echo "- $table: $count records\n";
        }
        
        return $totalInserted;
    }
    
    private static function parseValues($valueString)
    {
        $values = [];
        $current = '';
        $inQuotes = false;
        $quoteChar = null;
        
        for ($i = 0; $i < strlen($valueString); $i++) {
            $char = $valueString[$i];
            
            if (!$inQuotes && ($char === "'" || $char === '"')) {
                $inQuotes = true;
                $quoteChar = $char;
                continue;
            } elseif ($inQuotes && $char === $quoteChar) {
                $inQuotes = false;
                $quoteChar = null;
                continue;
            } elseif (!$inQuotes && $char === ',') {
                $values[] = self::convertValue(trim($current));
                $current = '';
                continue;
            }
            
            $current .= $char;
        }
        
        if (!empty($current)) {
            $values[] = self::convertValue(trim($current));
        }
        
        return $values;
    }
    
    private static function convertValue($value)
    {
        $value = trim($value);
        
        if (strtoupper($value) === 'NULL') {
            return null;
        }
        
        if (is_numeric($value)) {
            return str_contains($value, '.') ? (float)$value : (int)$value;
        }
        
        // Date/datetime
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                return Carbon::parse($value)->toISOString();
            } catch (Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }
}

// Check if running directly
if (php_sapi_name() === 'cli' && isset($argv[0]) && basename($argv[0]) === 'simple_sql_import.php') {
    $sqlFile = $argv[1] ?? __DIR__ . '/database/glx_for_import_mongo.sql';
    SimpleSqlImporter::run($sqlFile);
}
