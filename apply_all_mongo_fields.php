<?php
/**
 * Script to apply all generated MongoDB field types to existing model files
 * Based on the complete output from generate_mongo_fields.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Đọc output từ file đã generate
$outputFile = __DIR__ . '/mongo_fields_clean.txt';
$outputContent = file_get_contents($outputFile);

// Remove BOM if present
$outputContent = str_replace("\xEF\xBB\xBF", '', $outputContent);

function parseGeneratedOutput($content) {
    $models = [];
    
    // Use simpler approach with the clean file
    preg_match_all('/\/\/ ========== (.+?) Model ==========.*?protected static \$mongoFieldTypes = \[(.*?)\];/s', $content, $matches);
    
    for ($i = 0; $i < count($matches[1]); $i++) {
        $modelName = trim($matches[1][$i]);
        $fieldsStr = $matches[2][$i];
        
        // Parse individual fields
        preg_match_all("/\s*'([^']+)'\s*=>\s*'([^']+)',?/", $fieldsStr, $fieldMatches);
        
        $fields = [];
        for ($j = 0; $j < count($fieldMatches[1]); $j++) {
            $fields[$fieldMatches[1][$j]] = $fieldMatches[2][$j];
        }
        
        if (!empty($fields)) {
            $models[$modelName] = $fields;
        }
    }
    
    return $models;
}

function findExistingModelFiles() {
    $modelFiles = [];
    $files = glob(__DIR__ . '/app/Models/*.php');
    
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        // Skip special files
        if (strpos($filename, '_Meta') === false && 
            strpos($filename, 'ModelGlxBase') === false &&
            strpos($filename, '_bak') === false) {
            $modelFiles[$filename] = $file;
        }
    }
    
    return $modelFiles;
}

function updateModelWithFields($modelFile, $fields) {
    if (!file_exists($modelFile)) {
        return false;
    }
    
    $content = file_get_contents($modelFile);
    
    // Check if already has mongoFieldTypes
    if (strpos($content, 'protected static $mongoFieldTypes') !== false) {
        return true; // Already exists
    }
    
    // Generate field type code
    $fieldCode = "    /**\n";
    $fieldCode .= "     * Define MongoDB field types\n"; 
    $fieldCode .= "     * Auto-generated from SQL structure\n";
    $fieldCode .= "     */\n";
    $fieldCode .= "    protected static \$mongoFieldTypes = [\n";
    
    foreach ($fields as $field => $type) {
        $fieldCode .= "        '{$field}' => '{$type}',\n";
    }
    
    $fieldCode .= "    ];";
    
    // Find insertion point after protected $guarded
    $patterns = [
        '/^(\s*class\s+\w+\s+extends\s+\w+[^{]*\{.*?protected\s+\$guarded\s*=\s*\[.*?\];)/ms',
        '/^(\s*class\s+\w+\s+extends\s+\w+[^{]*\{.*?use\s+[^;]+;.*?protected\s+\$guarded\s*=\s*\[.*?\];)/ms'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            $replacement = $matches[1] . "\n\n" . $fieldCode;
            $content = str_replace($matches[1], $replacement, $content);
            
            file_put_contents($modelFile, $content);
            return true;
        }
    }
    
    return false;
}

// Main execution
echo "=== Applying All Generated MongoDB Field Types ===\n\n";

$generatedModels = parseGeneratedOutput($outputContent);
$existingModelFiles = findExistingModelFiles();

echo "Generated models: " . count($generatedModels) . "\n";
echo "Existing model files: " . count($existingModelFiles) . "\n\n";

$matched = 0;
$updated = 0;
$alreadyExists = 0;
$notFound = 0;

foreach ($generatedModels as $modelName => $fields) {
    if (isset($existingModelFiles[$modelName])) {
        $matched++;
        $result = updateModelWithFields($existingModelFiles[$modelName], $fields);
        
        if ($result === true) {
            $alreadyExists++;
            echo "✅ {$modelName} - already has field types (" . count($fields) . " fields)\n";
        } else {
            echo "❌ {$modelName} - failed to update\n";
        }
    } else {
        $notFound++;
        echo "⚠️  {$modelName} - model file not found\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 FINAL SUMMARY:\n";
echo "🎯 Total generated models: " . count($generatedModels) . "\n";
echo "📁 Existing model files: " . count($existingModelFiles) . "\n";
echo "✅ Models matched: {$matched}\n";
echo "🔄 Models updated: {$updated}\n";
echo "💯 Already had field types: {$alreadyExists}\n";
echo "⚠️  Model files not found: {$notFound}\n";
echo "📈 Coverage: " . round($matched > 0 ? ($matched / count($generatedModels)) * 100 : 0, 1) . "%\n";
echo str_repeat("=", 60) . "\n";

// List some models that don't have files
if ($notFound > 0) {
    echo "\n🔍 Models without corresponding files (first 20):\n";
    $count = 0;
    foreach ($generatedModels as $modelName => $fields) {
        if (!isset($existingModelFiles[$modelName]) && $count < 20) {
            echo "   - {$modelName}\n";
            $count++;
        }
    }
    if ($notFound > 20) {
        echo "   ... and " . ($notFound - 20) . " more\n";
    }
}
