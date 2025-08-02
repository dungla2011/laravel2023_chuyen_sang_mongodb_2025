<?php

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test MongoDB create operation and return values
try {
    echo "=== Testing MongoDB Create Operation ===\n";
    
    // Get the MenuTree model
    $model = new \App\Models\MenuTree();
    
    // Test 1: Create with parent_id = 0 (no ObjectId conversion)
    echo "\n1. Testing create with parent_id = 0:\n";
    $result1 = $model::create([
        'name' => 'Test Root Node',
        'parent_id' => 0
    ]);
    
    // Refresh to get the ID
    $result1->refresh();
    
    echo "Created object type: " . get_class($result1) . "\n";
    echo "Created object ID: " . $result1->id . "\n";
    echo "ID type: " . gettype($result1->id) . "\n";
    if ($result1->id) {
        echo "ID is ObjectId: " . ($result1->id instanceof ObjectId ? 'Yes' : 'No') . "\n";
    } else {
        echo "ID is null or empty\n";
    }
    
    // Test 2: Create with ObjectId parent_id
    echo "\n2. Testing create with ObjectId parent_id:\n";
    $parentObjectId = new ObjectId('688d7d5e397c13fd880fce49');
    $result2 = $model::create([
        'name' => 'Test Child Node',
        'parent_id' => $parentObjectId
    ]);
    
    // Refresh to get the ID
    $result2->refresh();
    
    echo "Created object type: " . get_class($result2) . "\n";
    echo "Created object ID: " . $result2->id . "\n";
    echo "ID type: " . gettype($result2->id) . "\n";
    if ($result2->id) {
        echo "ID is ObjectId: " . ($result2->id instanceof ObjectId ? 'Yes' : 'No') . "\n";
    } else {
        echo "ID is null or empty\n";
    }
    echo "Parent ID: " . $result2->parent_id . "\n";
    echo "Parent ID type: " . gettype($result2->parent_id) . "\n";
    echo "Parent ID is ObjectId: " . ($result2->parent_id instanceof ObjectId ? 'Yes' : 'No') . "\n";
    
    // Test 3: Check what ->id returns vs what the full object returns
    echo "\n3. Testing return values:\n";
    if ($result2->id) {
        echo "result->id value: " . $result2->id . "\n";
        echo "result->id class: " . get_class($result2->id) . "\n";
        echo "Can convert to string: " . (string)$result2->id . "\n";
    } else {
        echo "result->id is null\n";
    }
    
    // Test 4: Check JSON serialization
    echo "\n4. Testing JSON serialization:\n";
    $jsonResult = json_encode(['id' => $result2->id]);
    echo "JSON result: " . $jsonResult . "\n";
    
    // Test 5: Check _id field directly
    echo "\n5. Testing _id field directly:\n";
    if (isset($result2->_id)) {
        echo "_id value: " . $result2->_id . "\n";
        echo "_id type: " . gettype($result2->_id) . "\n";
        echo "_id is ObjectId: " . ($result2->_id instanceof ObjectId ? 'Yes' : 'No') . "\n";
    } else {
        echo "_id is not set\n";
    }
    
    // Clean up test data
    echo "\n5. Cleaning up test data:\n";
    $result1->delete();
    $result2->delete();
    echo "Test data cleaned up.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
