<?php
// Load the singularize function from generate_mongo_fields.php
$content = file_get_contents(__DIR__ . '/generate_mongo_fields.php');
preg_match('/function singularize\([^}]+}/', $content, $matches);
if ($matches) {
    eval($matches[0]);
}

// Test singularize function
echo "=== Testing Singularize Function ===\n";

$testWords = [
    'menu_trees' => 'MenuTree',
    'cache_key_values' => 'CacheKeyValue', 
    'crm_messages' => 'CrmMessage',
    'hateco_certificates' => 'HatecoCertificate',
    'hr_employees' => 'HrEmployee',
    'hr_job_titles' => 'HrJobTitle',
    'telescope_entries' => 'TelescopeEntry',
    'telescope_entry_tags' => 'TelescopeEntryTag',
    'personal_access_tokens' => 'PersonalAccessToken',
    'product_usages' => 'ProductUsage',
    'hr_user_expenses' => 'HrUserExpense'
];

function tableNameToModelName($tableName) {
    $parts = explode('_', $tableName);
    $modelName = '';
    
    foreach ($parts as $part) {
        $modelName .= ucfirst(singularize($part));
    }
    
    return $modelName;
}

foreach ($testWords as $tableName => $expected) {
    $result = tableNameToModelName($tableName);
    $status = ($result === $expected) ? '✅' : '❌';
    echo "{$status} {$tableName} -> {$result} (expected: {$expected})\n";
}
