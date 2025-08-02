<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Testing fixed parent_id query with ObjectId ===\n\n";

$targetParentId = '688d7d5e397c13fd880fce49';

try {
    echo "1. Testing corrected where query:\n";
    
    // Test the logic from the corrected code
    if ($targetParentId && is_string($targetParentId)) {
        echo "   Converting string '$targetParentId' to ObjectId\n";
        $objectId = new \MongoDB\BSON\ObjectId($targetParentId);
        $children = MenuTree::where('parent_id', $objectId)->get();
    } else {
        $children = MenuTree::where('parent_id', $targetParentId)->get();
    }
    
    echo "   Found " . $children->count() . " children\n\n";
    
    echo "2. Children list:\n";
    foreach ($children as $index => $child) {
        echo "   [$index] Name: " . $child->name . "\n";
        echo "       ID: " . $child->_id . "\n";
        echo "       Parent ID: " . $child->parent_id . "\n\n";
        
        // Test has_child logic
        $childId = $child->_id;
        if (is_string($childId)) {
            $childObjectId = new \MongoDB\BSON\ObjectId($childId);
            $grandChildren = MenuTree::where('parent_id', $childObjectId)->count();
        } else {
            $grandChildren = MenuTree::where('parent_id', $childId)->count();
        }
        
        echo "       Has " . $grandChildren . " children\n\n";
    }
    
    echo "3. Verification - testing expected records:\n";
    $expectedNames = ['Member Menu', 'Menu List', 'Tools', 'News', 'DEMO', 'Cloud Files', 'Admin Tools', 'CrmMessage', 'CostItem', 'PlanName', 'TMP', 'CrmMessageGroup', 'CrmAppInfo', 'PlanDefine', 'PlanDefineValue'];
    
    $foundNames = $children->pluck('name')->toArray();
    $matchCount = 0;
    
    foreach ($expectedNames as $expectedName) {
        if (in_array($expectedName, $foundNames)) {
            $matchCount++;
            echo "   ✅ Found: $expectedName\n";
        } else {
            echo "   ❌ Missing: $expectedName\n";
        }
    }
    
    echo "\n   Total matches: $matchCount / " . count($expectedNames) . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
