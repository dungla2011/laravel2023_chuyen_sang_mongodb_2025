<?php
$modelFiles = glob(__DIR__ . '/app/Models/*.php');
$mainModels = [];
$metaModels = [];

// Separate main models from meta models
foreach ($modelFiles as $file) {
    $modelName = basename($file, '.php');
    
    // Skip meta files and utility files
    if (strpos($modelName, '_Meta') !== false || 
        in_array($modelName, ['ModelGlxBase', 'GiaPhaMg', 'HrCommon', 'MediaFolder2', 'MediaItem2', 'NewsFolder_Meta', 'Product_bak', 'QuizTool', 'SkusProductVariantOption', 'UserGlx', 'demoMg', 'PlanCostItem'])) {
        $metaModels[] = $modelName;
        continue;
    }
    
    $mainModels[] = $file;
}

$withMongo = 0;
$withoutMongo = 0;

echo "=== Main Models MongoDB Field Types Status ===\n";

foreach ($mainModels as $file) {
    $content = file_get_contents($file);
    $modelName = basename($file, '.php');
    
    if (strpos($content, 'protected static $mongoFieldTypes') !== false) {
        $withMongo++;
    } else {
        $withoutMongo++;
        echo "❌ {$modelName} - missing mongoFieldTypes\n";
    }
}

echo "\n============================================================\n";
echo "📊 MAIN MODELS FINAL STATUS:\n";
echo "✅ With mongoFieldTypes: $withMongo models\n";
echo "❌ Missing mongoFieldTypes: $withoutMongo models\n";
echo "📁 Total main model files: " . count($mainModels) . "\n";
echo "📈 Completion rate: " . round(($withMongo / count($mainModels)) * 100, 1) . "%\n";
echo "\n📁 Meta models excluded: " . count($metaModels) . "\n";
echo "📁 Total files scanned: " . count($modelFiles) . "\n";
echo "============================================================\n";
