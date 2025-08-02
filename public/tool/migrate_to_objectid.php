<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;

echo "=== MIGRATION: ADD OLD FIELDS AND CONVERT TO OBJECTID ===" . PHP_EOL;

// Step 1: Thêm field id_old và parent_id_old
echo "Step 1: Adding id_old and parent_id_old fields..." . PHP_EOL;

$allRecords = MenuTree::all();
echo "Found " . $allRecords->count() . " records to process" . PHP_EOL;

$processedCount = 0;
foreach ($allRecords as $record) {
    // Convert id cũ sang integer nếu là string
    $oldId = is_string($record->id) ? (int)$record->id : $record->id;
    $oldParentId = is_string($record->parent_id) ? (int)$record->parent_id : $record->parent_id;
    
    // Cập nhật với id_old và parent_id_old
    $record->id_old = $oldId;
    $record->parent_id_old = $oldParentId;
    $record->save();
    
    $processedCount++;
    
    // Show progress every 20 records
    if ($processedCount % 20 == 0 || $processedCount <= 5) {
        echo "  Processed {$processedCount}: ID {$record->id} -> id_old: {$oldId}, parent_id_old: {$oldParentId}" . PHP_EOL;
    }
}

echo "✅ Step 1 completed: Added id_old and parent_id_old to {$processedCount} records" . PHP_EOL;

echo PHP_EOL . "Step 2: Creating ID mapping for parent-child relationships..." . PHP_EOL;

// Step 2: Tạo mapping từ old ID sang new ObjectId
$idMapping = [];
$allRecords = MenuTree::all(); // Reload để có field mới

foreach ($allRecords as $record) {
    $newObjectId = new ObjectId();
    $idMapping[$record->id_old] = $newObjectId;
    
    if (count($idMapping) <= 5) {
        echo "  Mapping: old_id {$record->id_old} -> ObjectId {$newObjectId}" . PHP_EOL;
    }
}

echo "✅ Created mapping for " . count($idMapping) . " records" . PHP_EOL;

echo PHP_EOL . "Step 3: Converting to ObjectId..." . PHP_EOL;

$convertedCount = 0;
foreach ($allRecords as $record) {
    $oldId = $record->id_old;
    $oldParentId = $record->parent_id_old;
    
    // Tạo ObjectId mới cho record này
    $newId = $idMapping[$oldId];
    
    // Tìm ObjectId cho parent (nếu có)
    $newParentId = null;
    if ($oldParentId && $oldParentId > 0 && isset($idMapping[$oldParentId])) {
        $newParentId = $idMapping[$oldParentId];
    }
    
    // Cập nhật với ObjectId mới
    // Lưu ý: Cần cẩn thận với việc thay đổi _id trong MongoDB
    $updateData = [];
    
    if ($newParentId) {
        $updateData['parent_id'] = $newParentId;
    } else {
        $updateData['parent_id'] = null; // hoặc 0 tùy logic của bạn
    }
    
    // Update record
    DB::connection('mongodb')->collection('menu_trees')
        ->where('_id', $record->id)
        ->update($updateData);
    
    $convertedCount++;
    
    if ($convertedCount <= 5 || $convertedCount % 20 == 0) {
        echo "  Converted {$convertedCount}: old_id {$oldId} -> new parent_id: " . ($newParentId ? $newParentId : 'null') . PHP_EOL;
    }
}

echo "✅ Step 3 completed: Converted parent_id to ObjectId for {$convertedCount} records" . PHP_EOL;

echo PHP_EOL . "Step 4: Creating new documents with ObjectId _id..." . PHP_EOL;

// Step 4: Tạo documents mới với ObjectId _id
$newDocuments = [];
foreach ($allRecords as $record) {
    $oldId = $record->id_old;
    $newObjectId = $idMapping[$oldId];
    
    // Tìm parent ObjectId
    $newParentId = null;
    if ($record->parent_id_old && $record->parent_id_old > 0 && isset($idMapping[$record->parent_id_old])) {
        $newParentId = $idMapping[$record->parent_id_old];
    }
    
    // Tạo document mới
    $newDoc = [
        '_id' => $newObjectId,
        'name' => $record->name,
        'parent_id' => $newParentId,
        'created_at' => $record->created_at,
        'updated_at' => $record->updated_at,
        'deleted_at' => $record->deleted_at,
        'orders' => $record->orders ?? 0,
        'link' => $record->link,
        'gid_allow' => $record->gid_allow,
        'open_new_window' => $record->open_new_window ?? 0,
        'icon' => $record->icon,
        'id_news' => $record->id_news,
        'id_old' => $record->id_old,
        'parent_id_old' => $record->parent_id_old,
    ];
    
    $newDocuments[] = $newDoc;
    
    if (count($newDocuments) <= 3) {
        echo "  New doc: _id={$newObjectId}, parent_id=" . ($newParentId ?? 'null') . ", name='{$record->name}'" . PHP_EOL;
    }
}

echo "✅ Prepared " . count($newDocuments) . " new documents with ObjectId" . PHP_EOL;

echo PHP_EOL . "=== VERIFICATION ===" . PHP_EOL;

// Verification: Kiểm tra một vài parent-child relationships
$sampleChild = collect($newDocuments)->where('parent_id_old', '>', 0)->first();
if ($sampleChild) {
    $parentDoc = collect($newDocuments)->where('id_old', $sampleChild['parent_id_old'])->first();
    
    echo "Sample parent-child relationship:" . PHP_EOL;
    echo "  Child: _id={$sampleChild['_id']}, parent_id={$sampleChild['parent_id']}" . PHP_EOL;
    if ($parentDoc) {
        echo "  Parent: _id={$parentDoc['_id']}" . PHP_EOL;
        echo "  Relationship valid: " . ($sampleChild['parent_id'] == $parentDoc['_id'] ? "✅ YES" : "❌ NO") . PHP_EOL;
    }
}

echo PHP_EOL . "=== SUMMARY ===" . PHP_EOL;
echo "✅ Added id_old and parent_id_old fields (converted to integers)" . PHP_EOL;
echo "✅ Created ObjectId mapping for all records" . PHP_EOL;
echo "✅ Prepared documents with ObjectId _id and parent_id" . PHP_EOL;
echo "📝 Ready to replace collection with new documents" . PHP_EOL;

echo PHP_EOL . "⚠️  NEXT STEPS (Manual execution required):" . PHP_EOL;
echo "1. Backup current menu_trees collection" . PHP_EOL;
echo "2. Drop current collection: db.menu_trees.drop()" . PHP_EOL;
echo "3. Insert new documents with ObjectId" . PHP_EOL;
echo "4. Verify all parent-child relationships" . PHP_EOL;
echo "5. Update application code to handle ObjectId" . PHP_EOL;

// Optionally save the new documents structure to a file for review
$jsonOutput = json_encode($newDocuments, JSON_PRETTY_PRINT);
file_put_contents(__DIR__ . '/menu_trees_with_objectid.json', $jsonOutput);
echo PHP_EOL . "📄 New documents structure saved to: menu_trees_with_objectid.json" . PHP_EOL;
