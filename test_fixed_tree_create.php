<?php

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test the fixed tree_create method
try {
    echo "=== Testing Fixed tree_create Method ===\n";
    
    // Create a repository instance
    $model = new \App\Models\MenuTree();
    $repo = new \App\Repositories\MenuTreeRepositorySql($model);
    
    // Create mock objParam
    $objParam = new \App\Components\clsParamRequestEx();
    $objParam->need_set_uid = 1;
    $objParam->userIdLogined = 1;
    
    // Test 1: Create root node (pid = 0)
    echo "\n1. Testing create root node (pid = 0):\n";
    
    $param1 = [
        'new_name' => 'Test Root Node - ' . date('H:i:s'),
        'pid' => 0
    ];
    
    try {
        $result1 = $repo->tree_create($param1, $objParam);
        echo "Result type: " . gettype($result1) . "\n";
        
        // Decode JSON response
        $decoded1 = json_decode($result1->getContent(), true);
        echo "Success: " . ($decoded1['errorCode'] == 0 ? 'Yes' : 'No') . "\n";
        echo "Returned ID: " . ($decoded1['dataRet'] ?? 'null') . "\n";
        echo "Message: " . ($decoded1['message'] ?? 'null') . "\n";
        
        if ($decoded1['errorCode'] == 0 && $decoded1['dataRet']) {
            echo "ID type validation: " . (is_string($decoded1['dataRet']) ? 'String (correct)' : gettype($decoded1['dataRet'])) . "\n";
            $rootId = $decoded1['dataRet'];
        }
        
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    // Test 2: Create child node (with parent_id as ObjectId string)
    echo "\n2. Testing create child node (with parent_id):\n";
    
    if (isset($rootId)) {
        $param2 = [
            'new_name' => 'Test Child Node - ' . date('H:i:s'),
            'pid' => $rootId  // Use the ID from the root node
        ];
        
        try {
            $result2 = $repo->tree_create($param2, $objParam);
            echo "Result type: " . gettype($result2) . "\n";
            
            // Decode JSON response
            $decoded2 = json_decode($result2->getContent(), true);
            echo "Success: " . ($decoded2['errorCode'] == 0 ? 'Yes' : 'No') . "\n";
            echo "Returned ID: " . ($decoded2['dataRet'] ?? 'null') . "\n";
            echo "Message: " . ($decoded2['message'] ?? 'null') . "\n";
            
            if ($decoded2['errorCode'] == 0 && $decoded2['dataRet']) {
                echo "ID type validation: " . (is_string($decoded2['dataRet']) ? 'String (correct)' : gettype($decoded2['dataRet'])) . "\n";
                $childId = $decoded2['dataRet'];
            }
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Skipping child test - no root ID available\n";
    }
    
    // Test 3: Verify the created objects in database
    echo "\n3. Verifying created objects in database:\n";
    
    if (isset($rootId)) {
        $rootObj = \App\Models\MenuTree::find($rootId);
        if ($rootObj) {
            echo "Root object found: Yes\n";
            echo "Root ID: " . $rootObj->id . "\n";
            echo "Root parent_id: " . ($rootObj->parent_id ?? 'null') . "\n";
            echo "Root name: " . $rootObj->name . "\n";
        } else {
            echo "Root object found: No\n";
        }
    }
    
    if (isset($childId)) {
        $childObj = \App\Models\MenuTree::find($childId);
        if ($childObj) {
            echo "Child object found: Yes\n";
            echo "Child ID: " . $childObj->id . "\n";
            echo "Child parent_id: " . $childObj->parent_id . "\n";
            echo "Child parent_id type: " . gettype($childObj->parent_id) . "\n";
            echo "Child parent_id is ObjectId: " . ($childObj->parent_id instanceof ObjectId ? 'Yes' : 'No') . "\n";
            echo "Child name: " . $childObj->name . "\n";
        } else {
            echo "Child object found: No\n";
        }
    }
    
    // Test 4: Test with existing ObjectId string
    echo "\n4. Testing with existing ObjectId string:\n";
    
    $param3 = [
        'new_name' => 'Test with Existing Parent - ' . date('H:i:s'),
        'pid' => '688d7d5e397c13fd880fce49'  // Known existing ObjectId
    ];
    
    try {
        $result3 = $repo->tree_create($param3, $objParam);
        $decoded3 = json_decode($result3->getContent(), true);
        echo "Success: " . ($decoded3['errorCode'] == 0 ? 'Yes' : 'No') . "\n";
        echo "Returned ID: " . ($decoded3['dataRet'] ?? 'null') . "\n";
        
        if ($decoded3['errorCode'] == 0) {
            $testId = $decoded3['dataRet'];
            $testObj = \App\Models\MenuTree::find($testId);
            if ($testObj) {
                echo "Object parent_id: " . $testObj->parent_id . "\n";
                echo "Parent_id matches expected: " . ($testObj->parent_id == '688d7d5e397c13fd880fce49' ? 'Yes' : 'No') . "\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    // Clean up test data
    echo "\n5. Cleaning up test data:\n";
    $cleanedUp = 0;
    
    $testObjects = \App\Models\MenuTree::where('name', 'like', 'Test%')->get();
    foreach ($testObjects as $obj) {
        echo "Deleting: " . $obj->name . " (ID: " . $obj->id . ")\n";
        $obj->delete();
        $cleanedUp++;
    }
    
    echo "Cleaned up $cleanedUp test objects.\n";
    
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
