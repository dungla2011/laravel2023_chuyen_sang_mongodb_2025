<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "=== VERIFY MIGRATION RESULTS ===" . PHP_EOL;

// Kiểm tra structure mới
$sampleRecord = MenuTree::first();
echo "Sample record structure:" . PHP_EOL;
echo "- id: '{$sampleRecord->id}' (type: " . gettype($sampleRecord->id) . ")" . PHP_EOL;
echo "- id_old: '{$sampleRecord->id_old}' (type: " . gettype($sampleRecord->id_old) . ")" . PHP_EOL;
echo "- parent_id: '{$sampleRecord->parent_id}' (type: " . gettype($sampleRecord->parent_id) . ")" . PHP_EOL;
echo "- parent_id_old: '{$sampleRecord->parent_id_old}' (type: " . gettype($sampleRecord->parent_id_old) . ")" . PHP_EOL;

echo PHP_EOL . "=== TESTING PARENT-CHILD RELATIONSHIPS ===" . PHP_EOL;

// Test relationship với ObjectId parent_id
$childRecord = MenuTree::where('parent_id_old', '>', 0)->first();
if ($childRecord) {
    echo "Child record:" . PHP_EOL;
    echo "- Name: '{$childRecord->name}'" . PHP_EOL;
    echo "- ID: {$childRecord->id} (old: {$childRecord->id_old})" . PHP_EOL;
    echo "- Parent ID: {$childRecord->parent_id} (old: {$childRecord->parent_id_old})" . PHP_EOL;
    
    // Tìm parent bằng id_old
    $parent = MenuTree::where('id_old', $childRecord->parent_id_old)->first();
    if ($parent) {
        echo "Parent found by id_old:" . PHP_EOL;
        echo "- Name: '{$parent->name}'" . PHP_EOL;
        echo "- ID: {$parent->id} (old: {$parent->id_old})" . PHP_EOL;
        
        // So sánh ObjectId
        echo "Parent-child ObjectId match: " . ($childRecord->parent_id == $parent->id ? "✅ YES" : "❌ NO") . PHP_EOL;
    }
}

echo PHP_EOL . "=== STATISTICS ===" . PHP_EOL;
$totalRecords = MenuTree::count();
$recordsWithOldFields = MenuTree::whereNotNull('id_old')->count();
$rootRecords = MenuTree::where('parent_id_old', 0)->count();
$childRecords = MenuTree::where('parent_id_old', '>', 0)->count();

echo "Total records: {$totalRecords}" . PHP_EOL;
echo "Records with old fields: {$recordsWithOldFields}" . PHP_EOL;
echo "Root records (parent_id_old = 0): {$rootRecords}" . PHP_EOL;
echo "Child records (parent_id_old > 0): {$childRecords}" . PHP_EOL;

echo PHP_EOL . "=== SAMPLE DATA ===" . PHP_EOL;
$samples = MenuTree::take(5)->get();
foreach ($samples as $i => $record) {
    echo "Record " . ($i + 1) . ":" . PHP_EOL;
    echo "  id: {$record->id} (old: {$record->id_old})" . PHP_EOL;
    echo "  parent_id: {$record->parent_id} (old: {$record->parent_id_old})" . PHP_EOL;
    echo "  name: '{$record->name}'" . PHP_EOL;
    echo PHP_EOL;
}

echo "=== JSON FILES CREATED ===" . PHP_EOL;
$jsonFiles = glob(__DIR__ . '/menu_trees_*.json');
foreach ($jsonFiles as $file) {
    $size = filesize($file);
    echo "- " . basename($file) . " (" . round($size/1024, 1) . " KB)" . PHP_EOL;
}

echo PHP_EOL . "✅ Migration verification completed!" . PHP_EOL;
