<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportSqlToMongo extends Command
{
    protected $signature = 'import:sql-to-mongo {file?}';
    protected $description = 'Import SQL file to MongoDB';

    public function handle()
    {
        $this->info('=== IMPORT SQL TO MONGODB ===');
        
        $sqlFile = $this->argument('file') ?? database_path('glx_for_import_mongo.sql');
        
        if (!file_exists($sqlFile)) {
            $this->error("File not found: $sqlFile");
            return 1;
        }
        
        $content = file_get_contents($sqlFile);
        $this->info("File loaded: " . number_format(strlen($content)) . " bytes");
        
        // Parse INSERT statements - support multi-row inserts
        $pattern = '/INSERT\s+INTO\s+`?(\w+)`?\s*\((.*?)\)\s*VALUES\s*(.*?);/is';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
        
        $this->info("Found " . count($matches) . " INSERT statements");
        
        $totalInserted = 0;
        $tables = [];
        $bar = $this->output->createProgressBar(count($matches));
        
        foreach ($matches as $match) {
            $tableName = $match[1];
            $columns = array_map('trim', explode(',', $match[2]));
            $valuesPart = $match[3];
            
            // Clean column names
            $columns = array_map(function($col) {
                return trim($col, '` ');
            }, $columns);
            
            // Parse multiple rows - split by ),( pattern
            $allRows = $this->parseMultiRowValues($valuesPart);
            
            foreach ($allRows as $values) {
                if (count($columns) === count($values)) {
                    $document = array_combine($columns, $values);
                    
                    // Add timestamps if needed
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
                        
                    } catch (\Exception $e) {
                        $this->error("Error in $tableName: " . $e->getMessage());
                    }
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->line('');
        
        $this->info("\n=== SUMMARY ===");
        $this->info("Total inserted: $totalInserted");
        
        foreach ($tables as $table => $count) {
            $this->line("- $table: $count records");
        }
        
        // Verify
        $this->info("\n=== VERIFICATION ===");
        foreach (array_keys($tables) as $tableName) {
            $count = DB::connection('mongodb')->table($tableName)->count();
            $this->line("MongoDB collection '$tableName': $count documents");
        }
        
        return 0;
    }
    
    private function parseMultiRowValues($valuesPart)
    {
        $allRows = [];
        $valuesPart = trim($valuesPart);
        
        // Split by ),( pattern for multiple rows
        $rows = preg_split('/\),\s*\(/s', $valuesPart);
        
        foreach ($rows as $i => $row) {
            // Clean up parentheses
            $row = trim($row, '() ');
            $values = $this->parseValues($row);
            $allRows[] = $values;
        }
        
        return $allRows;
    }
    
    private function parseValues($valueString)
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
                $values[] = $this->convertValue(trim($current));
                $current = '';
                continue;
            }
            
            $current .= $char;
        }
        
        if (!empty($current)) {
            $values[] = $this->convertValue(trim($current));
        }
        
        return $values;
    }
    
    private function convertValue($value)
    {
        $value = trim($value);
        
        if (strtoupper($value) === 'NULL') {
            return null;
        }
        
        if (is_numeric($value)) {
            return str_contains($value, '.') ? (float)$value : (int)$value;
        }
        
        // Handle dates
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            try {
                return Carbon::parse($value)->toISOString();
            } catch (\Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }
}
