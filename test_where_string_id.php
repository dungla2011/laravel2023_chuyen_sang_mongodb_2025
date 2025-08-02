<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Testing MongoDB where() with string ID vs ObjectId ===\n\n";

try {
    // Get a parent record that has children
    echo "1. Finding a parent record with children:\n";
    $parent = MenuTree::whereNotNull('parent_id')->first();
    if (!$parent) {
        echo "   No records with parent_id found, creating test data...\n";
        exit;
    }
    
    $parentId = $parent->parent_id;
    echo "   Parent ID: $parentId (type: " . gettype($parentId) . ")\n";
    
    // Test 2: Query children using string ID
    echo "\n2. Testing where('parent_id', string_id):\n";
    $childrenByString = MenuTree::where('parent_id', $parentId)->get();
    echo "   Found " . $childrenByString->count() . " children using string ID\n";
    
    // Test 3: Query children using ObjectId (if different)
    echo "\n3. Testing where('parent_id', ObjectId):\n";
    try {
        $objectId = new \MongoDB\BSON\ObjectId($parentId);
        $childrenByObjectId = MenuTree::where('parent_id', $objectId)->get();
        echo "   Found " . $childrenByObjectId->count() . " children using ObjectId\n";
    } catch (Exception $e) {
        echo "   Error creating ObjectId: " . $e->getMessage() . "\n";
    }
    
    // Test 4: Test with a specific string ID
    echo "\n4. Testing with a known string ID:\n";
    $testId = "688d7da3b8bf4e480b01ab02"; // Root record
    $childrenOfRoot = MenuTree::where('parent_id', $testId)->get();
    echo "   Children of '$testId': " . $childrenOfRoot->count() . " records\n";
    
    if ($childrenOfRoot->count() > 0) {
        echo "   ✅ SUCCESS: Can use string ID directly in where() queries\n";
        foreach ($childrenOfRoot as $child) {
            echo "     - " . $child->name . " (ID: " . $child->_id . ")\n";
        }
    } else {
        echo "   No children found for this parent\n";
    }
    
    // Test 5: Test comparison between results
    echo "\n5. Comparing results:\n";
    if (isset($childrenByString) && isset($childrenByObjectId)) {
        if ($childrenByString->count() == $childrenByObjectId->count()) {
            echo "   ✅ Both string and ObjectId queries return same count\n";
        } else {
            echo "   ❌ Different results: String=" . $childrenByString->count() . 
                 ", ObjectId=" . $childrenByObjectId->count() . "\n";
        }
    }
    
    // Test 6: Test with array format (like in the code)
    echo "\n6. Testing with array data format:\n";
    $allRecords = MenuTree::limit(5)->get()->toArray();
    foreach ($allRecords as $record) {
        // In MongoDB, the key might be 'id' or '_id'
        $id = $record['id'] ?? $record['_id'] ?? null;
        if ($id) {
            echo "   Record ID: $id (from array)\n";
            
            $children = MenuTree::where('parent_id', $id)->count();
            echo "   Children count: $children\n";
            break; // Just test one
        } else {
            echo "   No ID field found in record\n";
            print_r(array_keys($record));
        }
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
