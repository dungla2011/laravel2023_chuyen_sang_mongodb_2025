<?php
/**
 * Simple and robust script to apply MongoDB field types
 */

// Read input file
if (!isset($argv[1])) {
    echo "Usage: php simple_apply.php <mongo_fields_file>\n";
    exit(1);
}

$inputFile = $argv[1];
if (!file_exists($inputFile)) {
    echo "❌ File not found: $inputFile\n";
    exit(1);
}

$content = file_get_contents($inputFile);

// Use a different approach: find all model sections using preg_match_all
preg_match_all('/\/\/ ==========\s+(\w+)\s+Model\s+==========.*?protected static \$mongoFieldTypes = \[(.*?)\];/s', $content, $matches, PREG_SET_ORDER);

echo "=== Simple Apply MongoDB Field Types ===\n";
echo "Found " . count($matches) . " model definitions\n\n";

$applied = 0;
$skipped = 0;
$notFound = 0;

foreach ($matches as $match) {
    $modelName = trim($match[1]);
    $fieldsStr = $match[2];
    
    // Parse fields
    preg_match_all("/\s*'([^']+)'\s*=>\s*'([^']+)',?/", $fieldsStr, $fieldMatches);
    
    $fields = [];
    for ($i = 0; $i < count($fieldMatches[1]); $i++) {
        $fields[$fieldMatches[1][$i]] = $fieldMatches[2][$i];
    }
    
    if (empty($fields)) {
        echo "⚠️  {$modelName} - no fields parsed\n";
        continue;
    }
    
    // Find model file
    $modelFile = __DIR__ . "/app/Models/{$modelName}.php";
    
    if (!file_exists($modelFile)) {
        echo "⚠️  {$modelName} - model file not found\n";
        $notFound++;
        continue;
    }
    
    // Check if already has mongoFieldTypes
    $modelContent = file_get_contents($modelFile);
    if (strpos($modelContent, 'protected static $mongoFieldTypes') !== false) {
        echo "⏭️  {$modelName} - already has mongoFieldTypes (" . count($fields) . " fields)\n";
        $skipped++;
        continue;
    }
    
    // Add mongoFieldTypes
    $fieldCode = "\n    /**\n";
    $fieldCode .= "     * Define MongoDB field types\n"; 
    $fieldCode .= "     * Auto-generated from SQL structure\n";
    $fieldCode .= "     */\n";
    $fieldCode .= "    protected static \$mongoFieldTypes = [\n";
    
    foreach ($fields as $field => $type) {
        $fieldCode .= "        '{$field}' => '{$type}',\n";
    }
    
    $fieldCode .= "    ];\n";
    
    // Insert before closing brace
    $pattern = '/(\n\s*}\s*)$/';
    $replacement = $fieldCode . '$1';
    $newContent = preg_replace($pattern, $replacement, $modelContent);
    
    if ($newContent && $newContent !== $modelContent) {
        file_put_contents($modelFile, $newContent);
        echo "✅ {$modelName} - added mongoFieldTypes (" . count($fields) . " fields)\n";
        $applied++;
    } else {
        echo "❌ {$modelName} - failed to add mongoFieldTypes\n";
    }
}

echo "\n============================================================\n";
echo "📊 SUMMARY:\n";
echo "✅ Applied: $applied\n";
echo "⏭️  Skipped (already have): $skipped\n";
echo "⚠️  Not found: $notFound\n";
echo "📁 Total processed: " . count($matches) . "\n";
echo "============================================================\n";
