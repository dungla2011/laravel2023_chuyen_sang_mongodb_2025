<?php
/**
 * Script to apply MongoDB field types only to models that don't have them yet
 * Uses the clean output file
 */

require_once __DIR__ . '/vendor/autoload.php';

function parseCleanOutput($filePath) {
    $content = file_get_contents($filePath);
    $models = [];
    
    // Split by model sections
    $sections = explode('// ==========', $content);
    
    foreach ($sections as $section) {
        // Skip first section (header)
        if (strpos($section, 'Model ==========') === false) {
            continue;
        }
        
        // Extract model name
        if (preg_match('/^([^=]+?)Model ==========/', $section, $nameMatch)) {
            $modelName = trim($nameMatch[1]);
            
            // Extract mongoFieldTypes array
            if (preg_match('/protected static \$mongoFieldTypes = \[(.*?)\];/s', $section, $fieldsMatch)) {
                $fieldsStr = $fieldsMatch[1];
                
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

function hasMongoFieldTypes($modelFile) {
    if (!file_exists($modelFile)) {
        return false;
    }
    
    $content = file_get_contents($modelFile);
    return strpos($content, 'protected static $mongoFieldTypes') !== false;
}

function addMongoFieldTypes($modelFile, $fields) {
    $content = file_get_contents($modelFile);
    
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
        '/^(\s*class\s+\w+\s+extends\s+\w+[^{]*\{.*?use\s+[^;]+;.*?protected\s+\$guarded\s*=\s*\[.*?\];)/ms',
        '/^(\s*class\s+\w+\s+implements\s+\w+[^{]*\{.*?protected\s+\$guarded\s*=\s*\[.*?\];)/ms',
        '/^(\s*class\s+\w+\s+extends\s+\w+\s+implements\s+\w+[^{]*\{.*?protected\s+\$guarded\s*=\s*\[.*?\];)/ms'
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
echo "=== Applying MongoDB Field Types (Skip Existing) ===\n\n";

$generatedModels = parseCleanOutput(__DIR__ . '/mongo_fields_full.txt');
$existingModelFiles = findExistingModelFiles();

echo "📊 Found " . count($generatedModels) . " generated models\n";
echo "📁 Found " . count($existingModelFiles) . " existing model files\n\n";

$matched = 0;
$updated = 0;
$skipped = 0;
$failed = 0;
$notFound = 0;

foreach ($generatedModels as $modelName => $fields) {
    if (isset($existingModelFiles[$modelName])) {
        $matched++;
        $modelFile = $existingModelFiles[$modelName];
        
        if (hasMongoFieldTypes($modelFile)) {
            $skipped++;
            echo "⏭️  {$modelName} - already has mongoFieldTypes (" . count($fields) . " fields)\n";
        } else {
            if (addMongoFieldTypes($modelFile, $fields)) {
                $updated++;
                echo "✅ {$modelName} - added mongoFieldTypes (" . count($fields) . " fields)\n";
            } else {
                $failed++;
                echo "❌ {$modelName} - failed to add mongoFieldTypes\n";
            }
        }
    } else {
        $notFound++;
        echo "⚠️  {$modelName} - model file not found\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 FINAL SUMMARY:\n";
echo "🎯 Generated models processed: " . count($generatedModels) . "\n";
echo "📁 Existing model files: " . count($existingModelFiles) . "\n";
echo "🎯 Models matched: {$matched}\n";
echo "✅ Models updated: {$updated}\n";
echo "⏭️  Models skipped (already have): {$skipped}\n";
echo "❌ Models failed: {$failed}\n";
echo "⚠️  Model files not found: {$notFound}\n";
echo "📈 Success rate: " . round($matched > 0 ? ($updated / $matched) * 100 : 0, 1) . "%\n";
echo str_repeat("=", 60) . "\n";

// Show which models were updated
if ($updated > 0) {
    echo "\n🎉 SUCCESS! Added mongoFieldTypes to {$updated} models!\n";
    echo "Now run: php check_mongo_fields.php to see updated status\n";
}
