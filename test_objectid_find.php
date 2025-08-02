<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Testing MongoDB ObjectId Find Operations ===\n\n";

try {
    // Test 1: Get a record to see its actual ID structure
    echo "1. Getting first record to see ID structure:\n";
    $firstRecord = MenuTree::first();
    if ($firstRecord) {
        echo "   Record ID: " . $firstRecord->_id . "\n";
        echo "   ID Type: " . gettype($firstRecord->_id) . "\n";
        if (is_object($firstRecord->_id)) {
            echo "   ID Class: " . get_class($firstRecord->_id) . "\n";
        } else {
            echo "   ID is not an object, it's a: " . gettype($firstRecord->_id) . "\n";
        }
        echo "\n";
        
        // Test 2: Try to find using string version of ObjectId
        $pidString = (string)$firstRecord->_id;
        echo "2. Testing find with string ID: '$pidString'\n";
        
        $foundByString = MenuTree::find($pidString);
        if ($foundByString) {
            echo "   ✅ SUCCESS: Found record using string ID\n";
            echo "   Found record name: " . $foundByString->name . "\n";
        } else {
            echo "   ❌ FAILED: Could not find record using string ID\n";
        }
        
        // Test 3: Try to find using ObjectId object
        echo "\n3. Testing find with ObjectId object:\n";
        $foundByObjectId = MenuTree::find($firstRecord->_id);
        if ($foundByObjectId) {
            echo "   ✅ SUCCESS: Found record using ObjectId object\n";
            echo "   Found record name: " . $foundByObjectId->name . "\n";
        } else {
            echo "   ❌ FAILED: Could not find record using ObjectId object\n";
        }
        
        // Test 4: Try to find using new ObjectId from string
        echo "\n4. Testing find with new ObjectId created from string:\n";
        $newObjectId = new \MongoDB\BSON\ObjectId($pidString);
        $foundByNewObjectId = MenuTree::find($newObjectId);
        if ($foundByNewObjectId) {
            echo "   ✅ SUCCESS: Found record using new ObjectId from string\n";
            echo "   Found record name: " . $foundByNewObjectId->name . "\n";
        } else {
            echo "   ❌ FAILED: Could not find record using new ObjectId from string\n";
        }
        
        // Test 5: Test with the specific ID from user
        echo "\n5. Testing with specific ID: '688d7d5e397c13fd880fce49'\n";
        $specificId = "688d7d5e397c13fd880fce49";
        
        $foundSpecific = MenuTree::find($specificId);
        if ($foundSpecific) {
            echo "   ✅ SUCCESS: Found record with specific string ID\n";
            echo "   Found record name: " . $foundSpecific->name . "\n";
        } else {
            echo "   ❌ FAILED: Could not find record with specific string ID\n";
            
            // Try with ObjectId
            try {
                $specificObjectId = new \MongoDB\BSON\ObjectId($specificId);
                $foundSpecificObjectId = MenuTree::find($specificObjectId);
                if ($foundSpecificObjectId) {
                    echo "   ✅ SUCCESS: Found record with specific ObjectId\n";
                    echo "   Found record name: " . $foundSpecificObjectId->name . "\n";
                } else {
                    echo "   ❌ FAILED: Could not find record with specific ObjectId either\n";
                }
            } catch (Exception $e) {
                echo "   ❌ ERROR creating ObjectId: " . $e->getMessage() . "\n";
            }
        }
        
        // Test 6: Test where query
        echo "\n6. Testing where query with string ID:\n";
        $whereResult = MenuTree::where('_id', $pidString)->first();
        if ($whereResult) {
            echo "   ✅ SUCCESS: Found record using where with string ID\n";
        } else {
            echo "   ❌ FAILED: Could not find record using where with string ID\n";
        }
        
        // Test 7: Test where query with ObjectId
        echo "\n7. Testing where query with ObjectId:\n";
        $whereObjectIdResult = MenuTree::where('_id', $firstRecord->_id)->first();
        if ($whereObjectIdResult) {
            echo "   ✅ SUCCESS: Found record using where with ObjectId\n";
        } else {
            echo "   ❌ FAILED: Could not find record using where with ObjectId\n";
        }
        
    } else {
        echo "   No records found in MenuTree collection\n";
    }
    
    // Test 8: Check connection type
    echo "\n8. Database connection info:\n";
    $connection = MenuTree::getConnectionName();
    echo "   Connection: " . ($connection ?: 'default') . "\n";
    
    $actualConnection = MenuTree::resolveConnection();
    echo "   Connection class: " . get_class($actualConnection) . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
