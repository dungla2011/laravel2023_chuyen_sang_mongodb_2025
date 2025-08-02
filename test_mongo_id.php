<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING MONGODB ID TYPES ===" . PHP_EOL;

$model = new \App\Models\DemoTbl();

echo "1. Testing find(1) - integer:" . PHP_EOL;
$objFind1 = $model::find(1);
echo "Result: " . ($objFind1 ? "FOUND" : "NOT FOUND") . PHP_EOL;

echo PHP_EOL . "2. Testing find('1') - string:" . PHP_EOL;
$objFind2 = $model::find('1');
echo "Result: " . ($objFind2 ? "FOUND" : "NOT FOUND") . PHP_EOL;
if ($objFind2) {
    echo "Attributes: " . json_encode($objFind2->getAttributes()) . PHP_EOL;
}

echo PHP_EOL . "3. First few objects from all():" . PHP_EOL;
$allObjects = $model::take(5)->get();
foreach ($allObjects as $k => $obj) {
    echo "Index $k: ID='{$obj->id}' (type: " . gettype($obj->id) . ")" . PHP_EOL;
}

echo PHP_EOL . "=== SOLUTION ===" . PHP_EOL;
echo "MongoDB stores IDs as strings, not integers." . PHP_EOL;
echo "Use find('1') instead of find(1)" . PHP_EOL;
