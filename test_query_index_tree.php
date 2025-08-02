<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;
use App\Components\clsParamRequestEx;

echo "=== Testing queryIndexTree with corrected ObjectId handling ===\n\n";

try {
    $targetParentId = '688d7d5e397c13fd880fce49';
    
    echo "1. Testing the corrected queryIndexTree method:\n";
    
    // Create test parameters
    $param = [
        'pid' => $targetParentId
    ];
    
    $objParam = new clsParamRequestEx();
    $objParam->set_gid = 1;
    $objParam->need_set_uid = 0;
    
    $menuTree = new MenuTree();
    
    echo "   Calling queryIndexTree with pid = '$targetParentId'\n";
    
    $result = $menuTree->queryIndexTree($param, $objParam);
    
    if (is_array($result) && count($result) >= 2) {
        $children = $result[0];
        $parentInfo = $result[1];
        
        echo "   ✅ SUCCESS: Found " . count($children) . " children\n\n";
        
        echo "2. Children details:\n";
        foreach ($children as $index => $child) {
            echo "   [$index] Name: " . $child['name'] . "\n";
            echo "       ID: " . $child['id'] . "\n";
            echo "       Has Child: " . ($child['has_child'] ? 'YES' : 'NO') . "\n\n";
        }
        
        if ($parentInfo) {
            echo "3. Parent info:\n";
            echo "   Name: " . $parentInfo['name'] . "\n";
            echo "   Parent ID: " . $parentInfo['parent_id'] . "\n";
        }
        
    } else {
        echo "   Result: " . json_encode($result) . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
