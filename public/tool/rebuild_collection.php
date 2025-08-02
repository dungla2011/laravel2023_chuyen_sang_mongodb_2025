<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\DB;

echo "=== REBUILD MENU_TREES WITH FULL OBJECTID ===" . PHP_EOL;

// Step 1: Lấy toàn bộ dữ liệu hiện tại
echo "Step 1: Getting all current data..." . PHP_EOL;
$allData = MenuTree::all()->toArray();
echo "Found " . count($allData) . " records to rebuild" . PHP_EOL;

// Verify data structure
$sample = $allData[0];
if (!isset($sample['id_old']) || !isset($sample['parent_id_old'])) {
    echo "❌ Error: Missing id_old or parent_id_old fields!" . PHP_EOL;
    exit;
}

echo "✅ Data structure confirmed with old fields" . PHP_EOL;

// Step 2: Tạo ObjectId mapping từ id_old
echo PHP_EOL . "Step 2: Creating ObjectId mapping..." . PHP_EOL;
$objectIdMapping = [];

foreach ($allData as $record) {
    $oldId = $record['id_old'];
    $newObjectId = new ObjectId();
    $objectIdMapping[$oldId] = $newObjectId;
    
    if (count($objectIdMapping) <= 5) {
        echo "  old_id {$oldId} -> ObjectId {$newObjectId}" . PHP_EOL;
    }
}

echo "✅ Created ObjectId mapping for " . count($objectIdMapping) . " records" . PHP_EOL;

// Step 3: Tạo new documents với ObjectId _id và parent_id
echo PHP_EOL . "Step 3: Building new documents..." . PHP_EOL;
$newDocuments = [];

foreach ($allData as $record) {
    $oldId = $record['id_old'];
    $oldParentId = $record['parent_id_old'];
    
    // Lấy ObjectId cho record này
    $newId = $objectIdMapping[$oldId];
    
    // Lấy ObjectId cho parent (nếu có)
    $newParentId = null;
    if ($oldParentId && $oldParentId > 0 && isset($objectIdMapping[$oldParentId])) {
        $newParentId = $objectIdMapping[$oldParentId];
    }
    
    // Tạo document mới
    $newDoc = [
        '_id' => $newId,
        'name' => $record['name'],
        'parent_id' => $newParentId,
        'created_at' => $record['created_at'],
        'updated_at' => $record['updated_at'],
        'deleted_at' => $record['deleted_at'],
        'orders' => $record['orders'] ?? 0,
        'link' => $record['link'] ?? '',
        'gid_allow' => $record['gid_allow'] ?? '',
        'open_new_window' => $record['open_new_window'] ?? 0,
        'icon' => $record['icon'] ?? '',
        'id_news' => $record['id_news'] ?? '',
        'id_old' => $record['id_old'],           // Giữ để reference
        'parent_id_old' => $record['parent_id_old'], // Giữ để reference
    ];
    
    $newDocuments[] = $newDoc;
}

echo "✅ Built " . count($newDocuments) . " new documents with ObjectId" . PHP_EOL;

// Step 4: Verification
echo PHP_EOL . "Step 4: Verifying relationships..." . PHP_EOL;
$validRelationships = 0;
$totalWithParents = 0;

foreach ($newDocuments as $doc) {
    if ($doc['parent_id_old'] > 0) {
        $totalWithParents++;
        
        // Tìm parent document
        foreach ($newDocuments as $potentialParent) {
            if ($potentialParent['id_old'] == $doc['parent_id_old']) {
                if ($doc['parent_id'] == $potentialParent['_id']) {
                    $validRelationships++;
                }
                break;
            }
        }
    }
}

echo "Relationship validation: {$validRelationships}/{$totalWithParents} valid parent-child relationships" . PHP_EOL;

// Show sample relationships
echo PHP_EOL . "Sample relationships:" . PHP_EOL;
$samples = array_slice(array_filter($newDocuments, function($doc) { 
    return $doc['parent_id_old'] > 0; 
}), 0, 3);

foreach ($samples as $child) {
    $parent = array_filter($newDocuments, function($doc) use ($child) {
        return $doc['id_old'] == $child['parent_id_old'];
    });
    $parent = reset($parent);
    
    echo "  Child: '{$child['name']}' (old_id: {$child['id_old']})" . PHP_EOL;
    echo "    _id: {$child['_id']}" . PHP_EOL;
    echo "    parent_id: {$child['parent_id']}" . PHP_EOL;
    if ($parent) {
        echo "  Parent: '{$parent['name']}' (old_id: {$parent['id_old']})" . PHP_EOL;
        echo "    _id: {$parent['_id']}" . PHP_EOL;
        echo "  Match: " . ($child['parent_id'] == $parent['_id'] ? "✅ YES" : "❌ NO") . PHP_EOL;
    }
    echo PHP_EOL;
}

// Step 5: Create backup and new collection data
echo "Step 5: Preparing for collection replacement..." . PHP_EOL;

// Save current data as final backup
$backupFile = __DIR__ . '/menu_trees_final_backup_' . date('Y-m-d_H-i-s') . '.json';
file_put_contents($backupFile, json_encode($allData, JSON_PRETTY_PRINT));

// Save new documents (convert ObjectIds to strings for JSON)
$newFile = __DIR__ . '/menu_trees_new_objectid_' . date('Y-m-d_H-i-s') . '.json';
$jsonData = array_map(function($doc) {
    $doc['_id'] = (string)$doc['_id'];
    if ($doc['parent_id']) {
        $doc['parent_id'] = (string)$doc['parent_id'];
    }
    return $doc;
}, $newDocuments);

file_put_contents($newFile, json_encode($jsonData, JSON_PRETTY_PRINT));

echo "✅ Files created:" . PHP_EOL;
echo "  - Backup: " . basename($backupFile) . PHP_EOL;
echo "  - New data: " . basename($newFile) . PHP_EOL;

echo PHP_EOL . "=== READY TO EXECUTE REPLACEMENT ===" . PHP_EOL;
echo "⚠️  WARNING: This will completely replace the menu_trees collection!" . PHP_EOL;
echo PHP_EOL . "Manual steps to execute:" . PHP_EOL;
echo "1. Drop collection: db.menu_trees.drop()" . PHP_EOL;
echo "2. Import new data: mongoimport --db yourdb --collection menu_trees --file " . basename($newFile) . PHP_EOL;
echo "3. Verify all data" . PHP_EOL;

// Optionally, provide automatic execution
echo PHP_EOL . "🚀 AUTO-EXECUTE? (Uncomment to run)" . PHP_EOL;
echo "// Step 6: Execute replacement (DANGER ZONE)" . PHP_EOL;
echo "/*" . PHP_EOL;
echo "// Truncate current collection" . PHP_EOL;
echo "MenuTree::truncate();" . PHP_EOL;
echo "" . PHP_EOL;
echo "// Insert new documents" . PHP_EOL;
echo "foreach (\$newDocuments as \$doc) {" . PHP_EOL;
echo "    MenuTree::create(\$doc);" . PHP_EOL;
echo "}" . PHP_EOL;
echo "*/" . PHP_EOL;

echo PHP_EOL . "✅ Preparation completed! Ready for collection replacement." . PHP_EOL;
