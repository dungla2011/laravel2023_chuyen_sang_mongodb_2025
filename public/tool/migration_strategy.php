<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;

echo "=== MIGRATION STRATEGY: INTEGER TO OBJECTID ===" . PHP_EOL;

// 1. Tạo mapping table
echo "Step 1: Create mapping from old ID to new ObjectId" . PHP_EOL;
$mapping = [];

// Lấy tất cả records hiện tại
$allRecords = MenuTree::all();
echo "Found " . $allRecords->count() . " records to migrate" . PHP_EOL;

foreach ($allRecords as $record) {
    // Tạo ObjectId mới cho mỗi record
    $newObjectId = new ObjectId();
    $mapping[$record->id] = (string)$newObjectId;
    
    if (count($mapping) <= 5) { // Chỉ show 5 examples
        echo "  Old ID: {$record->id} -> New ObjectId: {$newObjectId}" . PHP_EOL;
    }
}

echo PHP_EOL . "Step 2: Update records with new ObjectIds" . PHP_EOL;
echo "Example migration code:" . PHP_EOL;
echo "foreach (\$records as \$record) {" . PHP_EOL;
echo "    \$oldId = \$record->id;" . PHP_EOL;
echo "    \$newObjectId = \$mapping[\$oldId];" . PHP_EOL;
echo "    " . PHP_EOL;
echo "    // Update parent_id to use new ObjectId" . PHP_EOL;
echo "    if (\$record->parent_id && isset(\$mapping[\$record->parent_id])) {" . PHP_EOL;
echo "        \$record->parent_id = new ObjectId(\$mapping[\$record->parent_id]);" . PHP_EOL;
echo "    }" . PHP_EOL;
echo "    " . PHP_EOL;
echo "    // Update _id to new ObjectId" . PHP_EOL;
echo "    \$record->_id = new ObjectId(\$newObjectId);" . PHP_EOL;
echo "    \$record->save();" . PHP_EOL;
echo "}" . PHP_EOL;

echo PHP_EOL . "Step 3: Verify parent-child relationships" . PHP_EOL;
$childrenCount = MenuTree::where('parent_id', '>', 0)->count();
echo "Records with parents: {$childrenCount}" . PHP_EOL;

echo PHP_EOL . "=== EXAMPLE BEFORE/AFTER ===" . PHP_EOL;
$example = MenuTree::where('parent_id', '>', 0)->first();
if ($example) {
    echo "BEFORE (current):" . PHP_EOL;
    echo "  Child: {" . PHP_EOL;
    echo "    \"id\": {$example->id}," . PHP_EOL;
    echo "    \"parent_id\": {$example->parent_id}," . PHP_EOL;
    echo "    \"name\": \"{$example->name}\"" . PHP_EOL;
    echo "  }" . PHP_EOL;
    
    $parentOld = MenuTree::find($example->parent_id);
    if ($parentOld) {
        echo "  Parent: {" . PHP_EOL;
        echo "    \"id\": {$parentOld->id}," . PHP_EOL;
        echo "    \"name\": \"{$parentOld->name}\"" . PHP_EOL;
        echo "  }" . PHP_EOL;
    }
    
    echo PHP_EOL . "AFTER (with ObjectId):" . PHP_EOL;
    $childNewId = $mapping[$example->id] ?? 'ObjectId("...")';
    $parentNewId = $mapping[$example->parent_id] ?? 'ObjectId("...")';
    
    echo "  Child: {" . PHP_EOL;
    echo "    \"_id\": ObjectId(\"{$childNewId}\")," . PHP_EOL;
    echo "    \"parent_id\": ObjectId(\"{$parentNewId}\")," . PHP_EOL;
    echo "    \"name\": \"{$example->name}\"" . PHP_EOL;
    echo "  }" . PHP_EOL;
    
    if ($parentOld) {
        echo "  Parent: {" . PHP_EOL;
        echo "    \"_id\": ObjectId(\"{$parentNewId}\")," . PHP_EOL;
        echo "    \"name\": \"{$parentOld->name}\"" . PHP_EOL;
        echo "  }" . PHP_EOL;
    }
}

echo PHP_EOL . "=== FINAL ANSWER ===" . PHP_EOL;
echo "✅ YES: If id becomes ObjectId, then parent_id MUST also be ObjectId" . PHP_EOL;
echo "✅ This ensures referential integrity and optimal performance" . PHP_EOL;
echo "✅ Both fields should always have the same data type" . PHP_EOL;
