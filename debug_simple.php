<?php

// Khởi tạo Laravel
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG FIND vs ALL ===" . PHP_EOL;

// Test với DemoTbl model
try {
    $model = new \App\Models\DemoTbl();
    
    echo "1. Testing find(1):" . PHP_EOL;
    $objFind = $model::find(1);
    if ($objFind) {
        echo "Found object with find(1): ID=" . $objFind->id . PHP_EOL;
        echo "Object type: " . get_class($objFind) . PHP_EOL;
        echo "Attributes: " . json_encode($objFind->getAttributes()) . PHP_EOL;
    } else {
        echo "No object found with find(1)" . PHP_EOL;
    }

    echo PHP_EOL . "2. Testing all() and looking for id=1:" . PHP_EOL;
    $allObjects = $model::all();
    echo "Total objects in all(): " . $allObjects->count() . PHP_EOL;
    
    $foundInAll = null;
    foreach ($allObjects as $k => $v) {
        if ($v->id == 1) {
            $foundInAll = $v;
            echo "Found object with id=1 in all(): Index=$k, ID=" . $v->id . PHP_EOL;
            echo "Object type: " . get_class($v) . PHP_EOL;
            echo "Attributes: " . json_encode($v->getAttributes()) . PHP_EOL;
            break;
        }
    }

    if (!$foundInAll) {
        echo "No object with id=1 found in all() results" . PHP_EOL;
        echo "Available IDs in all(): ";
        foreach ($allObjects->take(10) as $obj) {
            echo $obj->id . " ";
        }
        echo PHP_EOL;
    }

    echo PHP_EOL . "3. Comparison:" . PHP_EOL;
    if ($objFind && $foundInAll) {
        echo "Are they equal? " . (json_encode($objFind->getAttributes()) === json_encode($foundInAll->getAttributes()) ? "YES" : "NO") . PHP_EOL;
        
        // So sánh từng attribute
        $findAttrs = $objFind->getAttributes();
        $allAttrs = $foundInAll->getAttributes();
        
        foreach ($findAttrs as $key => $value) {
            if (!isset($allAttrs[$key])) {
                echo "- $key: only in find(1) = '$value'" . PHP_EOL;
            } elseif ($allAttrs[$key] !== $value) {
                echo "- $key: find(1)='$value' vs all()='{$allAttrs[$key]}'" . PHP_EOL;
            }
        }
        
        foreach ($allAttrs as $key => $value) {
            if (!isset($findAttrs[$key])) {
                echo "- $key: only in all() = '$value'" . PHP_EOL;
            }
        }
    }

    echo PHP_EOL . "4. Database info:" . PHP_EOL;
    echo "Connection: " . ($model->getConnectionName() ?: 'default') . PHP_EOL;
    echo "Table: " . $model->getTable() . PHP_EOL;

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo "Try with User model instead..." . PHP_EOL;
    
    // Fallback to User model
    try {
        $model = new \App\Models\User();
        
        echo PHP_EOL . "=== Testing with User model ===" . PHP_EOL;
        
        $objFind = $model::find(1);
        if ($objFind) {
            echo "User find(1): " . json_encode($objFind->getAttributes()) . PHP_EOL;
        }
        
        $allUsers = $model::all();
        echo "Total users: " . $allUsers->count() . PHP_EOL;
        
        foreach ($allUsers as $user) {
            if ($user->id == 1) {
                echo "User all()[id=1]: " . json_encode($user->getAttributes()) . PHP_EOL;
                break;
            }
        }
        
    } catch (\Exception $e2) {
        echo "Error with User model: " . $e2->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "=== END DEBUG ===" . PHP_EOL;
