<?php

/**
 * Script to generate $mongoFieldTypes for all models based on SQL structure
 */

// Đọc file SQL
$sqlFile = __DIR__ . '/database/glx2023_struct_full.sql';
$sqlContent = file_get_contents($sqlFile);

// Parse SQL để tìm các table và fields
function parseSqlTables($sqlContent) {
    preg_match_all('/CREATE TABLE `([^`]+)` \((.*?)\) ENGINE/s', $sqlContent, $matches);
    
    $tables = [];
    for ($i = 0; $i < count($matches[1]); $i++) {
        $tableName = $matches[1][$i];
        $tableContent = $matches[2][$i];
        
        // Parse fields
        preg_match_all('/`([^`]+)`\s+([^\s,]+)[^,]*(?:,|$)/m', $tableContent, $fieldMatches);
        
        $fields = [];
        for ($j = 0; $j < count($fieldMatches[1]); $j++) {
            $fieldName = $fieldMatches[1][$j];
            $fieldType = $fieldMatches[2][$j];
            
            // Convert SQL type to MongoDB type
            $mongoType = sqlTypeToMongoType($fieldType);
            $fields[$fieldName] = $mongoType;
        }
        
        $tables[$tableName] = $fields;
    }
    
    return $tables;
}

function sqlTypeToMongoType($sqlType) {
    $sqlType = strtolower($sqlType);
    
    if (strpos($sqlType, 'int') !== false || strpos($sqlType, 'bigint') !== false) {
        return 'int';
    } elseif (strpos($sqlType, 'varchar') !== false || strpos($sqlType, 'text') !== false || strpos($sqlType, 'mediumtext') !== false) {
        return 'string';
    } elseif (strpos($sqlType, 'timestamp') !== false || strpos($sqlType, 'datetime') !== false || strpos($sqlType, 'date') !== false) {
        return 'date';
    } elseif (strpos($sqlType, 'decimal') !== false || strpos($sqlType, 'float') !== false || strpos($sqlType, 'double') !== false) {
        return 'double';
    } elseif (strpos($sqlType, 'boolean') !== false || strpos($sqlType, 'tinyint') !== false || strpos($sqlType, 'smallint') !== false) {
        return 'boolean';
    } else {
        return 'string'; // default
    }
}

function generateModelClass($tableName, $fields) {
    $className = ucfirst(camelCase(singularize($tableName)));
    
    $mongoFields = ['        \'_id\' => \'objectId\','];
    
    foreach ($fields as $fieldName => $fieldType) {
        $mongoFields[] = "        '$fieldName' => '$fieldType',";
    }
    
    $mongoFieldsStr = implode("\n", $mongoFields);
    
    return "
    /**
     * Define MongoDB field types for {$className} model
     * Based on SQL: CREATE TABLE `{$tableName}` (...)
     */
    protected static \$mongoFieldTypes = [
{$mongoFieldsStr}
    ];";
}

function camelCase($string) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
}

function singularize($word) {
    // Skip already singular words
    $alreadySingular = [
        'media', 'data', 'info', 'log', 'meta', 'todo', 'demo', 'crm', 'hr', 'ocr',
        'quiz', 'typing', 'giapha', 'telesale', 'monitor', 'order', 'partner', 
        'payment', 'transport', 'uploader', 'site', 'sku'
    ];
    
    $lowerWord = strtolower($word);
    if (in_array($lowerWord, $alreadySingular)) {
        return $word;
    }
    
    // Specific rules first (most specific to least specific)
    $specificRules = [
        'access$' => 'access',
        'trees$' => 'tree',
        'employees$' => 'employee',  
        'certificates$' => 'certificate',
        'expenses$' => 'expense',
        'tokens$' => 'token',
        'responses$' => 'response',
        'enterprises$' => 'enterprise',
        'purchases$' => 'purchase',
        'licenses$' => 'license',
        'practices$' => 'practice',
        'devices$' => 'device',
        'invoices$' => 'invoice',
        'provinces$' => 'province',
        'images$' => 'image',
        'usages$' => 'usage',
        'advantages$' => 'advantage',
        'damages$' => 'damage',
        'packages$' => 'package',
        'messages$' => 'message',
        'passages$' => 'passage',
        'presences$' => 'presence',
        'references$' => 'reference',
        'differences$' => 'difference',
        'preferences$' => 'preference',
        'performances$' => 'performance',
        'instances$' => 'instance',
        'distances$' => 'distance',
        'sentences$' => 'sentence',
        'offenses$' => 'offense',
        'defenses$' => 'defense',
        'interfaces$' => 'interface',
        'surfaces$' => 'surface',
        'purposes$' => 'purpose',
        'promises$' => 'promise',
        'courses$' => 'course',
        'sources$' => 'source',
        'resources$' => 'resource',
        'forces$' => 'force',
        'horses$' => 'horse',
        'houses$' => 'house',
        'causes$' => 'cause',
        'clauses$' => 'clause',
        'uses$' => 'use',
        'bases$' => 'base',
        'cases$' => 'case',
        'phases$' => 'phase',
        'phrases$' => 'phrase',
        'releases$' => 'release',
        'increases$' => 'increase',
        'decreases$' => 'decrease',
        'leases$' => 'lease',
        'diseases$' => 'disease',
        'exercises$' => 'exercise',
        'compromises$' => 'compromise',
        'analyses$' => 'analysis',
        'syntheses$' => 'synthesis',
        'theses$' => 'thesis',
        'hypotheses$' => 'hypothesis',
        'crises$' => 'crisis',
        'oases$' => 'oasis',
        'diagnoses$' => 'diagnosis',
        'prognoses$' => 'prognosis',
        'parentheses$' => 'parenthesis',
        'ellipses$' => 'ellipsis',
        'synopses$' => 'synopsis',
        'metropolises$' => 'metropolis',
        'necropolises$' => 'necropolis',
        'children$' => 'child',
        'feet$' => 'foot',
        'teeth$' => 'tooth',
        'geese$' => 'goose',
        'mice$' => 'mouse',
        'men$' => 'man',
        'women$' => 'woman',
        'people$' => 'person',
        'oxen$' => 'ox',
        'sheep$' => 'sheep',
        'deer$' => 'deer',
        'fish$' => 'fish',
        'series$' => 'series',
        'species$' => 'species',
        'data$' => 'datum',
        'media$' => 'medium',
        'criteria$' => 'criterion',
        'phenomena$' => 'phenomenon',
        'categories$' => 'category',
        'companies$' => 'company',
        'countries$' => 'country',
        'cities$' => 'city',
        'histories$' => 'history',
        'stories$' => 'story',
        'activities$' => 'activity',
        'facilities$' => 'facility',
        'accessories$' => 'accessory',
        'choices$' => 'choice',
        'files$' => 'file',
        'titles$' => 'title',
        'infos$' => 'info',
        'logs$' => 'log', 
        'items$' => 'item',
        'users$' => 'user',
        'events$' => 'event',
        'groups$' => 'group',
        'folders$' => 'folder',
        'variants$' => 'variant',
        'options$' => 'option',
        'sessions$' => 'session',
        'lessons$' => 'lesson',
        'results$' => 'result',
        'tests$' => 'test',
        'tools$' => 'tool',
        'classes$' => 'class',
        'answers$' => 'answer',
        'questions$' => 'question',
        'cards$' => 'card',
        'entries$' => 'entry',
        'tags$' => 'tag',
        'values$' => 'value',
        'configs$' => 'config',
        'settings$' => 'setting',
        'monitorings$' => 'monitoring',
    ];

    // Apply specific rules
    foreach ($specificRules as $pattern => $replacement) {
        if (preg_match('/' . $pattern . '/i', $word)) {
            return preg_replace('/' . $pattern . '/i', $replacement, $word);
        }
    }

    // General rules (applied after specific rules)
    $generalRules = [
        'ies$' => 'y',      // cities -> city, companies -> company
        'ves$' => 'fe',     // lives -> life, knives -> knife
        'oes$' => 'o',      // heroes -> hero, potatoes -> potato
        'ches$' => 'ch',    // matches -> match, watches -> watch
        'shes$' => 'sh',    // dishes -> dish, brushes -> brush
        'xes$' => 'x',      // boxes -> box, taxes -> tax
        'zes$' => 'z',      // quizzes -> quiz
        'sses$' => 'ss',    // classes -> class, addresses -> address
        's$' => '',         // cars -> car, books -> book (most common)
    ];

    // Apply general rules
    foreach ($generalRules as $pattern => $replacement) {
        if (preg_match('/' . $pattern . '/i', $word)) {
            return preg_replace('/' . $pattern . '/i', $replacement, $word);
        }
    }

    return $word; // If no rule matches, return the original word
}

// Parse SQL
$tables = parseSqlTables($sqlContent);

// Auto-generate mapping cho tất cả tables
function tableNameToModelName($tableName) {
    // Loại bỏ prefix nếu có
    $cleanName = $tableName;
    
    // Convert snake_case to PascalCase và singularize
    $parts = explode('_', $cleanName);
    $modelName = '';
    
    foreach ($parts as $part) {
        $modelName .= ucfirst(singularize($part));
    }
    
    return $modelName;
}

// Tạo mapping cho TẤT CẢ tables
$allTables = [];
foreach ($tables as $tableName => $fields) {
    $modelName = tableNameToModelName($tableName);
    $allTables[$tableName] = $modelName;
}

echo "Generated MongoDB field types for ALL models:\n\n";

foreach ($allTables as $tableName => $modelName) {
    if (isset($tables[$tableName])) {
        echo "// ========== {$modelName} Model ==========\n";
        echo generateModelClass($tableName, $tables[$tableName]);
        echo "\n\n";
    }
}

echo "\nTotal tables processed: " . count($tables) . "\n";
echo "ALL models generated: " . count($allTables) . "\n";
