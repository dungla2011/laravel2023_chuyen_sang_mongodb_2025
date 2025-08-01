<?php
$modelFiles = glob(__DIR__ . '/app/Models/*.php');
$withMongo = 0;
$withoutMongo = 0;

echo "=== MongoDB Field Types Status ===\n";

foreach ($modelFiles as $file) {
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
echo "📊 FINAL STATUS:\n";
echo "✅ With mongoFieldTypes: $withMongo models\n";
echo "❌ Missing mongoFieldTypes: $withoutMongo models\n";
echo "📁 Total model files: " . count($modelFiles) . "\n";
echo "📈 Completion rate: " . round(($withMongo / count($modelFiles)) * 100, 1) . "%\n";
echo "============================================================\n";
