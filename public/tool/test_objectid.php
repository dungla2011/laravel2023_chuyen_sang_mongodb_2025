<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;

echo "=== TESTING OBJECTID CONVERSION ===" . PHP_EOL;

// 1. Kiểm tra dữ liệu hiện tại
echo "1. Current data types:" . PHP_EOL;
$obj = MenuTree::find(319);
if ($obj) {
    echo "Object 319: ID='{$obj->id}' (type: " . gettype($obj->id) . "), parent_id='{$obj->parent_id}' (type: " . gettype($obj->parent_id) . ")" . PHP_EOL;
} else {
    echo "Object 319 not found, trying with string..." . PHP_EOL;
    $obj = MenuTree::find('319');
    if ($obj) {
        echo "Object '319': ID='{$obj->id}' (type: " . gettype($obj->id) . "), parent_id='{$obj->parent_id}' (type: " . gettype($obj->parent_id) . ")" . PHP_EOL;
    } else {
        echo "Object 319 not found in database" . PHP_EOL;
    }
}

echo PHP_EOL . "2. Testing ObjectId creation:" . PHP_EOL;

// Tạo ObjectId mới
$newObjectId = new ObjectId();
echo "New ObjectId: " . $newObjectId . " (type: " . gettype($newObjectId) . ")" . PHP_EOL;
echo "ObjectId string: " . (string)$newObjectId . PHP_EOL;

echo PHP_EOL . "3. Scenario: If we convert to ObjectId:" . PHP_EOL;

// Mô phỏng chuyển đổi
$parentObjectId = new ObjectId();
$childObjectId = new ObjectId();

echo "Parent ObjectId: " . $parentObjectId . PHP_EOL;
echo "Child ObjectId: " . $childObjectId . PHP_EOL;
echo "Child's parent_id would be: " . $parentObjectId . " (same as parent's _id)" . PHP_EOL;

echo PHP_EOL . "4. Real-world example with existing data:" . PHP_EOL;

// Lấy một object có parent
$childObj = MenuTree::where('parent_id', '>', 0)->first();
if ($childObj) {
    echo "Current structure:" . PHP_EOL;
    echo "  Child ID: {$childObj->id} (type: " . gettype($childObj->id) . ")" . PHP_EOL;
    echo "  Parent ID ref: {$childObj->parent_id} (type: " . gettype($childObj->parent_id) . ")" . PHP_EOL;
    
    $parent = MenuTree::find($childObj->parent_id);
    if ($parent) {
        echo "  Actual parent ID: {$parent->id} (type: " . gettype($parent->id) . ")" . PHP_EOL;
        echo "  Match: " . ($childObj->parent_id == $parent->id ? "YES" : "NO") . PHP_EOL;
    }
    
    echo PHP_EOL . "If converted to ObjectId:" . PHP_EOL;
    echo "  Child _id: ObjectId('...')" . PHP_EOL;
    echo "  Child parent_id: ObjectId('...') // Reference to parent's _id" . PHP_EOL;
    echo "  Parent _id: ObjectId('...')" . PHP_EOL;
}

echo PHP_EOL . "=== ANSWER TO YOUR QUESTION ===" . PHP_EOL;
echo "YES, if you convert 'id' to ObjectId, then 'parent_id' should also be ObjectId." . PHP_EOL;
echo PHP_EOL;
echo "Reasons:" . PHP_EOL;
echo "1. Consistency: Foreign keys should match primary key types" . PHP_EOL;
echo "2. Performance: ObjectId comparisons are optimized in MongoDB" . PHP_EOL;
echo "3. Standards: MongoDB best practices recommend ObjectId for references" . PHP_EOL;
echo "4. Indexing: Better index performance with matching types" . PHP_EOL;
echo PHP_EOL;
echo "Migration strategy:" . PHP_EOL;
echo "1. Create new ObjectId for each document" . PHP_EOL;
echo "2. Update all parent_id references to use new ObjectIds" . PHP_EOL;
echo "3. Update application code to handle ObjectId instead of integers" . PHP_EOL;
