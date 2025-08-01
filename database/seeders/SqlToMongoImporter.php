<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SqlToMongoImporter
{
    private $sqlFile;
    private $modelMappings = [
        'block_uis' => \App\Models\BlockUi::class,
        'menu_trees' => \App\Models\MenuTree::class,
        // Add more table => model mappings here
    ];

    public function __construct($sqlFile)
    {
        $this->sqlFile = $sqlFile;
    }

    public function import()
    {
        if (!file_exists($this->sqlFile)) {
            throw new \Exception("SQL file not found: {$this->sqlFile}");
        }

        $content = file_get_contents($this->sqlFile);
        
        // Parse INSERT statements
        $this->parseAndImportInserts($content);
    }

    private function parseAndImportInserts($content)
    {
        // Find all INSERT INTO statements
        preg_match_all('/INSERT INTO `(\w+)`\s*\(([^)]+)\)\s*VALUES\s*(.+?);/s', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $tableName = $match[1];
            $columns = $this->parseColumns($match[2]);
            $values = $this->parseValues($match[3]);

            if (isset($this->modelMappings[$tableName])) {
                $this->importTable($tableName, $columns, $values);
            }
        }
    }

    private function parseColumns($columnsString)
    {
        $columns = array_map(function($col) {
            return trim(str_replace('`', '', $col));
        }, explode(',', $columnsString));
        
        return $columns;
    }

    private function parseValues($valuesString)
    {
        $rows = [];
        
        // Split by ),( to get individual rows
        $valuesString = trim($valuesString);
        
        // Handle multiline values with proper parsing
        preg_match_all('/\(([^)]*(?:\([^)]*\)[^)]*)*)\)/s', $valuesString, $valueMatches);
        
        foreach ($valueMatches[1] as $rowValues) {
            $values = $this->parseRowValues($rowValues);
            $rows[] = $values;
        }
        
        return $rows;
    }

    private function parseRowValues($rowString)
    {
        $values = [];
        $current = '';
        $inQuotes = false;
        $quoteChar = '';
        $escaped = false;
        
        for ($i = 0; $i < strlen($rowString); $i++) {
            $char = $rowString[$i];
            
            if ($escaped) {
                $current .= $char;
                $escaped = false;
                continue;
            }
            
            if ($char === '\\') {
                $escaped = true;
                $current .= $char;
                continue;
            }
            
            if (!$inQuotes && ($char === "'" || $char === '"')) {
                $inQuotes = true;
                $quoteChar = $char;
                continue;
            }
            
            if ($inQuotes && $char === $quoteChar) {
                $inQuotes = false;
                $quoteChar = '';
                continue;
            }
            
            if (!$inQuotes && $char === ',') {
                $values[] = $this->convertValue(trim($current));
                $current = '';
                continue;
            }
            
            $current .= $char;
        }
        
        // Add the last value
        if ($current !== '') {
            $values[] = $this->convertValue(trim($current));
        }
        
        return $values;
    }

    private function convertValue($value)
    {
        $value = trim($value);
        
        if ($value === 'NULL') {
            return null;
        }
        
        // Handle quoted strings
        if (preg_match('/^[\'"](.*)[\'"]\s*$/', $value, $matches)) {
            return stripslashes($matches[1]);
        }
        
        // Handle numbers
        if (is_numeric($value)) {
            return strpos($value, '.') !== false ? (float)$value : (int)$value;
        }
        
        return $value;
    }

    private function importTable($tableName, $columns, $rows)
    {
        $modelClass = $this->modelMappings[$tableName];
        
        echo "Importing {$tableName} ({$modelClass})...\n";
        
        // Clear existing data
        $modelClass::truncate();
        
        foreach ($rows as $row) {
            $data = [];
            
            for ($i = 0; $i < count($columns); $i++) {
                $column = $columns[$i];
                $value = isset($row[$i]) ? $row[$i] : null;
                
                // Convert MySQL 'id' to MongoDB '_id'
                if ($column === 'id') {
                    $data['_id'] = (string)$value;
                } else {
                    // Handle timestamp fields
                    if (in_array($column, ['created_at', 'updated_at', 'deleted_at']) && $value && $value !== '0000-00-00 00:00:00') {
                        try {
                            $data[$column] = Carbon::parse($value);
                        } catch (\Exception $e) {
                            $data[$column] = null;
                        }
                    } else {
                        $data[$column] = $value;
                    }
                }
            }
            
            try {
                $modelClass::create($data);
            } catch (\Exception $e) {
                echo "Error importing row: " . $e->getMessage() . "\n";
                echo "Data: " . json_encode($data) . "\n";
            }
        }
        
        echo "Imported " . count($rows) . " records to {$tableName}\n";
    }
}
