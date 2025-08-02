<?php

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test MongoDB create operation and return values
try {
    echo "=== Testing MongoDB Create Operation (Simple) ===\n";
    
    // Get the MenuTree model
    $model = new \App\Models\MenuTree();
    
    // Test 1: Create with parent_id = 0 (no ObjectId conversion)
    echo "\n1. Testing create with parent_id = 0:\n";
    
    // Check fillable fields
    echo "Fillable fields: " . implode(', ', $model->getFillable()) . "\n";
    
    try {
        $result1 = $model::create([
            'name' => 'Test Root Node',
            'parent_id' => 0
        ]);
        
        echo "Create result type: " . get_class($result1) . "\n";
        echo "Has ID: " . ($result1->id ? 'Yes' : 'No') . "\n";
        echo "Has _id: " . (isset($result1->_id) ? 'Yes' : 'No') . "\n";
        
        if ($result1->id) {
            echo "ID value: " . $result1->id . "\n";
            echo "ID type: " . gettype($result1->id) . "\n";
        }
        
        if (isset($result1->_id)) {
            echo "_id value: " . $result1->_id . "\n";
            echo "_id type: " . gettype($result1->_id) . "\n";
        }
        
        // Check all attributes
        echo "All attributes: " . json_encode($result1->getAttributes()) . "\n";
        
        // Try to find it in database
        $found = \App\Models\MenuTree::where('name', 'Test Root Node')->first();
        if ($found) {
            echo "Found in database: Yes\n";
            echo "Found ID: " . $found->id . "\n";
            echo "Found _id: " . (isset($found->_id) ? $found->_id : 'null') . "\n";
            
            // Clean up
            $found->delete();
        } else {
            echo "Found in database: No\n";
        }
        
    } catch (\Exception $e) {
        echo "Error creating: " . $e->getMessage() . "\n";
    }
    
    // Test 2: Test the ObjectId conversion for parent_id
    echo "\n2. Testing ObjectId conversion for parent_id:\n";
    
    $pid = '688d7d5e397c13fd880fce49';
    echo "Original pid (string): $pid\n";
    
    if ($pid) {
        $pidObjectId = new \MongoDB\BSON\ObjectId($pid);
        echo "Converted pid (ObjectId): " . $pidObjectId . "\n";
        echo "ObjectId type: " . gettype($pidObjectId) . "\n";
        echo "ObjectId class: " . get_class($pidObjectId) . "\n";
    }
    
    // Test 3: Simple check on return value from create
    echo "\n3. Testing what create() returns:\n";
    
    try {
        $result = \App\Models\MenuTree::create([
            'name' => 'Test Simple',
            'parent_id' => new \MongoDB\BSON\ObjectId($pid)
        ]);
        
        echo "Create returns: " . gettype($result) . "\n";
        echo "Is Model instance: " . ($result instanceof \Illuminate\Database\Eloquent\Model ? 'Yes' : 'No') . "\n";
        
        if ($result) {
            echo "result->id: " . ($result->id ?? 'null') . "\n";
            echo "result->_id: " . ($result->_id ?? 'null') . "\n";
            
            // What should be returned to API?
            echo "\nFor API return:\n";
            echo "Using result->id: " . ($result->id ?? 'null') . "\n";
            echo "Using (string)result->_id: " . (string)($result->_id ?? '') . "\n";
            
            // JSON serialization test
            $jsonTest = json_encode(['id' => $result->id, '_id' => $result->_id]);
            echo "JSON serialization: " . $jsonTest . "\n";
            
            // Clean up
            if ($result->id || $result->_id) {
                $result->delete();
            }
        }
        
    } catch (\Exception $e) {
        echo "Error in test 3: " . $e->getMessage() . "\n";
    }
    
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
