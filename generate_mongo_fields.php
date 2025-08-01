<?php

/**
 * Script to generate $mongoFieldTypes for all models based on SQL structure
 */

// Đọc file SQL
$sqlFile = __DIR__ . '/database/glx2023_struct.sql';
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
    // Simple singularization rules
    $rules = [
        's$' => '',
        'ies$' => 'y',
        'ves$' => 'f',
        'logs$' => 'log',
        'infos$' => 'info',
        'items$' => 'item',
        'users$' => 'user',
        'events$' => 'event',
    ];
    
    foreach ($rules as $pattern => $replacement) {
        if (preg_match('/' . $pattern . '/i', $word)) {
            return preg_replace('/' . $pattern . '/i', $replacement, $word);
        }
    }
    
    return $word;
}

// Parse SQL
$tables = parseSqlTables($sqlContent);

// Tạo mapping table -> model
$importantTables = [
    'block_uis' => 'BlockUi',
    'categories' => 'Category', 
    'change_logs' => 'ChangeLog',
    'menus' => 'Menu',
    'news' => 'News',
    'roles' => 'Role', 
    'users' => 'User',
    'permissions' => 'Permission',
    'carts' => 'Cart',
    'cart_items' => 'CartItem',
    'conference_cats' => 'ConferenceCat',
    'conference_infos' => 'ConferenceInfo',
    'cost_items' => 'CostItem',
    'crm_app_infos' => 'CrmAppInfo',
    'crm_messages' => 'CrmMessage',
    'crm_message_groups' => 'CrmMessageGroup',
    'departments' => 'Department',
    'department_events' => 'DepartmentEvent',
    'department_users' => 'DepartmentUser',
    'download_logs' => 'DownloadLog',
    'event_and_users' => 'EventAndUser',
    'event_face_infos' => 'EventFaceInfo',
    'event_infos' => 'EventInfo',
    'event_registers' => 'EventRegister',
    'file_uploads' => 'FileUpload',
    'folder_files' => 'FolderFile',
    'news_folders' => 'NewsFolder',
    'notifications' => 'Notification',
    'products' => 'Product',
    'product_folders' => 'ProductFolder',
    'product_tags' => 'ProductTag',
    'tags' => 'Tag',
];

echo "Generated MongoDB field types for models:\n\n";

foreach ($importantTables as $tableName => $modelName) {
    if (isset($tables[$tableName])) {
        echo "// ========== {$modelName} Model ==========\n";
        echo generateModelClass($tableName, $tables[$tableName]);
        echo "\n\n";
    }
}

echo "\nTotal tables processed: " . count($tables) . "\n";
echo "Important models generated: " . count($importantTables) . "\n";
