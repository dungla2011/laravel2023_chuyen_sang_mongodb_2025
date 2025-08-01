<?php
/**
 * Check which models have MongoDB field types defined
 */

require_once __DIR__ . '/vendor/autoload.php';

function findModelFiles($directory = 'app/Models') {
    $models = [];
    $files = glob($directory . '/*.php');
    
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        // Skip Meta models and other special files  
        if (strpos($filename, '_Meta') === false && strpos($filename, 'ModelGlxBase') === false) {
            $models[] = $filename;
        }
    }
    
    return $models;
}

function checkModelFieldTypes($modelName) {
    $modelFile = __DIR__ . "/app/Models/{$modelName}.php";
    
    if (!file_exists($modelFile)) {
        return ['status' => 'not_found', 'file' => $modelFile];
    }
    
    $content = file_get_contents($modelFile);
    
    if (strpos($content, 'protected static $mongoFieldTypes') !== false) {
        // Count the number of fields
        preg_match('/protected\s+static\s+\$mongoFieldTypes\s*=\s*\[(.*?)\];/s', $content, $matches);
        if (isset($matches[1])) {
            $fieldsCount = substr_count($matches[1], '=>');
            return ['status' => 'has_fields', 'count' => $fieldsCount];
        }
        return ['status' => 'has_fields', 'count' => 0];
    }
    
    return ['status' => 'missing'];
}

echo "=== MongoDB Field Types Status Report ===\n\n";

$models = findModelFiles();
$withFields = [];
$withoutFields = [];
$notFound = [];

foreach ($models as $model) {
    $result = checkModelFieldTypes($model);
    
    switch ($result['status']) {
        case 'has_fields':
            $withFields[$model] = $result['count'];
            break;
        case 'missing':
            $withoutFields[] = $model;
            break;
        case 'not_found':
            $notFound[] = $model;
            break;
    }
}

echo "✅ Models WITH MongoDB field types (" . count($withFields) . "):\n";
echo str_repeat("-", 50) . "\n";
foreach ($withFields as $model => $count) {
    echo sprintf("%-30s | %2d fields\n", $model, $count);
}

echo "\n❌ Models WITHOUT MongoDB field types (" . count($withoutFields) . "):\n";
echo str_repeat("-", 50) . "\n";
foreach ($withoutFields as $model) {
    echo "- {$model}\n";
}

if (!empty($notFound)) {
    echo "\n⚠️  Model files not found (" . count($notFound) . "):\n";
    echo str_repeat("-", 50) . "\n";
    foreach ($notFound as $model) {
        echo "- {$model}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 SUMMARY:\n";
echo "✅ With field types: " . count($withFields) . " models\n";
echo "❌ Missing field types: " . count($withoutFields) . " models\n";
echo "⚠️  Files not found: " . count($notFound) . " models\n";
echo "📁 Total models checked: " . count($models) . "\n";
echo "📈 Completion rate: " . round((count($withFields) / count($models)) * 100, 1) . "%\n";
echo str_repeat("=", 60) . "\n";
