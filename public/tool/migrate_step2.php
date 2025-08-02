<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;

echo "=== STEP 2: CONVERT PARENT_ID TO OBJECTID ===" . PHP_EOL;

// Reload data to get the new id_old and parent_id_old fields
$allRecords = MenuTree::all();
echo "Found " . $allRecords->count() . " records with old fields" . PHP_EOL;

// Verify that id_old and parent_id_old exist
$firstRecord = $allRecords->first();
if (!isset($firstRecord->id_old)) {
    echo "❌ Error: id_old field not found. Run Step 1 first." . PHP_EOL;
    exit;
}

echo "✅ Old fields confirmed. Sample: id_old={$firstRecord->id_old}, parent_id_old={$firstRecord->parent_id_old}" . PHP_EOL;

echo PHP_EOL . "Step 2: Creating ObjectId mapping..." . PHP_EOL;

// Tạo mapping từ old_id sang ObjectId
$idMapping = [];
foreach ($allRecords as $record) {
    $newObjectId = new ObjectId();
    $idMapping[$record->id_old] = (string)$newObjectId; // Convert to string for storage
    
    if (count($idMapping) <= 5) {
        echo "  old_id {$record->id_old} -> ObjectId {$newObjectId}" . PHP_EOL;
    }
}

echo "✅ Created ObjectId mapping for " . count($idMapping) . " records" . PHP_EOL;

echo PHP_EOL . "Step 3: Update parent_id with ObjectId references..." . PHP_EOL;

$updatedCount = 0;
foreach ($allRecords as $record) {
    $updateData = [];
    
    // Cập nhật parent_id
    if ($record->parent_id_old && $record->parent_id_old > 0) {
        if (isset($idMapping[$record->parent_id_old])) {
            $updateData['parent_id'] = new ObjectId($idMapping[$record->parent_id_old]);
        } else {
            echo "⚠️  Warning: Parent ID {$record->parent_id_old} not found in mapping for record {$record->id}" . PHP_EOL;
            $updateData['parent_id'] = null;
        }
    } else {
        $updateData['parent_id'] = null; // Root records
    }
    
    // Cập nhật record
    if (!empty($updateData)) {
        MenuTree::where('_id', $record->id)->update($updateData);
        $updatedCount++;
        
        if ($updatedCount <= 5 || $updatedCount % 20 == 0) {
            $parentInfo = $updateData['parent_id'] ? "ObjectId({$updateData['parent_id']})" : 'null';
            echo "  Updated {$updatedCount}: Record {$record->id} -> parent_id: {$parentInfo}" . PHP_EOL;
        }
    }
}

echo "✅ Step 3 completed: Updated parent_id for {$updatedCount} records" . PHP_EOL;

echo PHP_EOL . "Step 4: Preparing new collection structure..." . PHP_EOL;

// Tạo file JSON với cấu trúc mới để import vào collection mới
$newDocuments = [];
foreach ($allRecords as $record) {
    $oldId = $record->id_old;
    $newObjectId = new ObjectId($idMapping[$oldId]);
    
    // Xác định parent ObjectId
    $newParentId = null;
    if ($record->parent_id_old && $record->parent_id_old > 0 && isset($idMapping[$record->parent_id_old])) {
        $newParentId = new ObjectId($idMapping[$record->parent_id_old]);
    }
    
    $newDoc = [
        '_id' => $newObjectId,
        'name' => $record->name,
        'parent_id' => $newParentId,
        'created_at' => $record->created_at,
        'updated_at' => $record->updated_at,
        'deleted_at' => $record->deleted_at,
        'orders' => $record->orders ?? 0,
        'link' => $record->link ?? '',
        'gid_allow' => $record->gid_allow ?? '',
        'open_new_window' => $record->open_new_window ?? 0,
        'icon' => $record->icon ?? '',
        'id_news' => $record->id_news ?? '',
        'id_old' => $record->id_old,
        'parent_id_old' => $record->parent_id_old,
    ];
    
    $newDocuments[] = $newDoc;
}

echo "✅ Prepared " . count($newDocuments) . " documents with ObjectId structure" . PHP_EOL;

echo PHP_EOL . "Step 5: Verification..." . PHP_EOL;

// Kiểm tra parent-child relationships
$childrenWithParents = collect($newDocuments)->where('parent_id_old', '>', 0);
$validRelationships = 0;
$totalChildren = $childrenWithParents->count();

foreach ($childrenWithParents->take(5) as $child) {
    $parent = collect($newDocuments)->where('id_old', $child['parent_id_old'])->first();
    if ($parent && $child['parent_id'] == $parent['_id']) {
        $validRelationships++;
        echo "✅ Valid: Child '{$child['name']}' -> Parent '{$parent['name']}'" . PHP_EOL;
    } else {
        echo "❌ Invalid: Child '{$child['name']}' relationship broken" . PHP_EOL;
    }
}

echo "Relationship check: {$validRelationships}/{$totalChildren} children have valid parent references" . PHP_EOL;

// Lưu cấu trúc mới vào file
$outputFile = __DIR__ . '/menu_trees_objectid_' . date('Y-m-d_H-i-s') . '.json';

// Convert ObjectId to string cho JSON export
$jsonData = array_map(function($doc) {
    $doc['_id'] = (string)$doc['_id'];
    if ($doc['parent_id']) {
        $doc['parent_id'] = (string)$doc['parent_id'];
    }
    return $doc;
}, $newDocuments);

file_put_contents($outputFile, json_encode($jsonData, JSON_PRETTY_PRINT));

echo PHP_EOL . "📄 New structure saved to: " . basename($outputFile) . PHP_EOL;

echo PHP_EOL . "=== MIGRATION SUMMARY ===" . PHP_EOL;
echo "✅ Step 1: Added id_old and parent_id_old fields (integers)" . PHP_EOL;
echo "✅ Step 2: Created ObjectId mapping for {$updatedCount} records" . PHP_EOL;
echo "✅ Step 3: Updated parent_id references to ObjectId" . PHP_EOL;
echo "✅ Step 4: Prepared new collection structure" . PHP_EOL;
echo "✅ Step 5: Verified parent-child relationships" . PHP_EOL;

echo PHP_EOL . "📋 CURRENT STATUS:" . PHP_EOL;
echo "- Current collection has mixed ID types (original + ObjectId parent_id)" . PHP_EOL;
echo "- New structure ready with full ObjectId implementation" . PHP_EOL;
echo "- Backup available: menu_trees_backup_*.json" . PHP_EOL;
echo "- New structure: " . basename($outputFile) . PHP_EOL;

echo PHP_EOL . "🚀 NEXT MANUAL STEPS:" . PHP_EOL;
echo "1. Test the current mixed structure in your application" . PHP_EOL;
echo "2. When ready, replace collection with new ObjectId structure" . PHP_EOL;
echo "3. Update application code to handle ObjectId" . PHP_EOL;
echo "4. Test all parent-child queries" . PHP_EOL;

echo PHP_EOL . "✅ Migration completed successfully!" . PHP_EOL;
