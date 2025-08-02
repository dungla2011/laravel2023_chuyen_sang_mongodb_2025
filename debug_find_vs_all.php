<?php

require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Foundation\Application;
use App\Models\DemoTbl; // Model có sẵn trong project

$app = Application::getInstance();
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUG FIND vs ALL ===" . PHP_EOL;

// Sử dụng DemoTbl model 
$model = new DemoTbl();

echo "1. Testing find(1):" . PHP_EOL;
$objFind = $model::find(1);
if ($objFind) {
    echo "Found object with find(1): ID=" . $objFind->id . PHP_EOL;
    echo "Object type: " . get_class($objFind) . PHP_EOL;
    echo "Object data: " . json_encode($objFind->toArray()) . PHP_EOL;
} else {
    echo "No object found with find(1)" . PHP_EOL;
}

echo PHP_EOL . "2. Testing all() and looking for id=1:" . PHP_EOL;
$allObjects = $model::all();
$foundInAll = null;

foreach ($allObjects as $k => $v) {
    if ($v->id == 1) {
        $foundInAll = $v;
        echo "Found object with id=1 in all(): Index=$k, ID=" . $v->id . PHP_EOL;
        echo "Object type: " . get_class($v) . PHP_EOL;
        echo "Object data: " . json_encode($v->toArray()) . PHP_EOL;
        break;
    }
}

if (!$foundInAll) {
    echo "No object with id=1 found in all() results" . PHP_EOL;
}

echo PHP_EOL . "3. Comparison:" . PHP_EOL;
if ($objFind && $foundInAll) {
    echo "Are they the same object? " . (($objFind->id === $foundInAll->id) ? "YES" : "NO") . PHP_EOL;
    echo "find(1) attributes: " . implode(", ", array_keys($objFind->getAttributes())) . PHP_EOL;
    echo "all()[id=1] attributes: " . implode(", ", array_keys($foundInAll->getAttributes())) . PHP_EOL;
    
    // So sánh từng attribute
    $findAttrs = $objFind->getAttributes();
    $allAttrs = $foundInAll->getAttributes();
    
    echo PHP_EOL . "Attribute differences:" . PHP_EOL;
    foreach ($findAttrs as $key => $value) {
        if (!isset($allAttrs[$key])) {
            echo "- $key: only in find(1)" . PHP_EOL;
        } elseif ($allAttrs[$key] !== $value) {
            echo "- $key: find(1)='$value' vs all()='{$allAttrs[$key]}'" . PHP_EOL;
        }
    }
    
    foreach ($allAttrs as $key => $value) {
        if (!isset($findAttrs[$key])) {
            echo "- $key: only in all()" . PHP_EOL;
        }
    }
}

echo PHP_EOL . "4. Database connection info:" . PHP_EOL;
echo "Connection: " . $model->getConnectionName() . PHP_EOL;
echo "Table: " . $model->getTable() . PHP_EOL;

echo PHP_EOL . "=== END DEBUG ===" . PHP_EOL;
