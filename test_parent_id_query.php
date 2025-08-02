<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Testing parent_id query with specific ID ===\n\n";

$targetParentId = '688d7d5e397c13fd880fce49';

try {
    echo "1. Testing where('parent_id', '$targetParentId'):\n";
    
    $children = MenuTree::where('parent_id', $targetParentId)->get();
    
    echo "   Found " . $children->count() . " children\n\n";
    
    if ($children->count() > 0) {
        echo "2. Children details:\n";
        foreach ($children as $index => $child) {
            echo "   [$index] ID: " . $child->_id . "\n";
            echo "       Name: " . $child->name . "\n";
            echo "       Parent ID: " . $child->parent_id . "\n";
            echo "       Parent ID Type: " . gettype($child->parent_id) . "\n\n";
        }
        
        echo "3. Verification - checking if parent exists:\n";
        $parent = MenuTree::find($targetParentId);
        if ($parent) {
            echo "   ✅ Parent found: " . $parent->name . "\n";
            echo "   Parent ID: " . $parent->_id . "\n";
        } else {
            echo "   ❌ Parent not found\n";
        }
        
        echo "\n4. Raw query test with toArray():\n";
        $childrenArray = MenuTree::where('parent_id', $targetParentId)->get()->toArray();
        foreach ($childrenArray as $index => $child) {
            echo "   [$index] Name: " . $child['name'] . "\n";
            echo "       ID: " . $child['id'] . "\n";
            echo "       Parent ID: " . $child['parent_id'] . "\n";
        }
        
    } else {
        echo "   No children found for parent_id = '$targetParentId'\n";
        
        echo "\n3. Let's check what parent_ids exist in the database:\n";
        $allRecords = MenuTree::limit(10)->get();
        foreach ($allRecords as $record) {
            if ($record->parent_id) {
                echo "   Record: " . $record->name . " has parent_id: " . $record->parent_id . " (type: " . gettype($record->parent_id) . ")\n";
            }
        }
    }
    
    echo "\n5. Testing different query methods:\n";
    
    // Method 1: Standard where
    $count1 = MenuTree::where('parent_id', $targetParentId)->count();
    echo "   where('parent_id', string): $count1 records\n";
    
    // Method 2: Where with exact match
    $count2 = MenuTree::where('parent_id', '=', $targetParentId)->count();
    echo "   where('parent_id', '=', string): $count2 records\n";
    
    // Method 3: Raw where
    $count3 = MenuTree::whereRaw("parent_id = ?", [$targetParentId])->count();
    echo "   whereRaw: $count3 records\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
