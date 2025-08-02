<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Detailed Investigation of parent_id matching ===\n\n";

$targetParentId = '688d7d5e397c13fd880fce49';

try {
    echo "1. Finding all records and examining parent_id values:\n";
    
    $allRecords = MenuTree::all();
    $matchingRecords = [];
    
    foreach ($allRecords as $record) {
        if ($record->parent_id) {
            $parentIdString = (string)$record->parent_id;
            $parentIdType = gettype($record->parent_id);
            
            echo "   Record: " . $record->name . "\n";
            echo "     parent_id: $parentIdString\n";
            echo "     type: $parentIdType\n";
            echo "     matches target: " . ($parentIdString === $targetParentId ? 'YES' : 'NO') . "\n";
            
            if ($parentIdString === $targetParentId) {
                $matchingRecords[] = $record;
            }
            echo "\n";
        }
    }
    
    echo "2. Manual matching results:\n";
    echo "   Found " . count($matchingRecords) . " records manually\n\n";
    
    if (count($matchingRecords) > 0) {
        echo "3. Manually found records:\n";
        foreach ($matchingRecords as $record) {
            echo "   - " . $record->name . " (ID: " . $record->_id . ")\n";
        }
        echo "\n";
    }
    
    echo "4. Testing different ObjectId conversions:\n";
    
    // Try with ObjectId conversion
    try {
        $objectId = new \MongoDB\BSON\ObjectId($targetParentId);
        $count4 = MenuTree::where('parent_id', $objectId)->count();
        echo "   where('parent_id', ObjectId): $count4 records\n";
    } catch (Exception $e) {
        echo "   ObjectId conversion error: " . $e->getMessage() . "\n";
    }
    
    echo "\n5. Raw MongoDB query test:\n";
    
    // Get the raw collection
    $collection = MenuTree::raw(function($collection) use ($targetParentId) {
        // Test with string
        $count1 = $collection->countDocuments(['parent_id' => $targetParentId]);
        echo "   Raw query with string: $count1 records\n";
        
        // Test with ObjectId
        try {
            $objectId = new \MongoDB\BSON\ObjectId($targetParentId);
            $count2 = $collection->countDocuments(['parent_id' => $objectId]);
            echo "   Raw query with ObjectId: $count2 records\n";
        } catch (Exception $e) {
            echo "   Raw ObjectId error: " . $e->getMessage() . "\n";
        }
        
        // Find documents and examine their parent_id field
        $docs = $collection->find(['parent_id' => ['$exists' => true]], ['limit' => 10]);
        echo "\n   Sample parent_id values from raw query:\n";
        foreach ($docs as $doc) {
            $parentId = $doc['parent_id'];
            echo "     " . $doc['name'] . ": " . $parentId . " (type: " . gettype($parentId) . ")\n";
            if ((string)$parentId === $targetParentId) {
                echo "       ^ THIS MATCHES!\n";
            }
        }
    });
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== Investigation Complete ===\n";
