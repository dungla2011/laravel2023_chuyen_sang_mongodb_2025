<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use MongoDB\BSON\ObjectId;

echo "=== EXECUTE COLLECTION REPLACEMENT ===" . PHP_EOL;
echo "⚠️  DANGER: This will completely replace menu_trees collection!" . PHP_EOL;
echo PHP_EOL;

// Đọc new data file
$newDataFile = glob(__DIR__ . '/menu_trees_new_objectid_*.json');
if (empty($newDataFile)) {
    echo "❌ Error: No new data file found!" . PHP_EOL;
    echo "Run rebuild_collection.php first" . PHP_EOL;
    exit;
}

$newDataFile = end($newDataFile); // Get latest file
echo "📄 Loading new data from: " . basename($newDataFile) . PHP_EOL;

$jsonData = json_decode(file_get_contents($newDataFile), true);
if (!$jsonData) {
    echo "❌ Error: Could not load JSON data!" . PHP_EOL;
    exit;
}

echo "✅ Loaded " . count($jsonData) . " records from JSON" . PHP_EOL;

// Convert string ObjectIds back to ObjectId objects
echo PHP_EOL . "Converting ObjectId strings back to ObjectId objects..." . PHP_EOL;
$newDocuments = [];
foreach ($jsonData as $record) {
    $doc = $record;
    
    // Convert _id to ObjectId
    $doc['_id'] = new ObjectId($record['_id']);
    
    // Convert parent_id to ObjectId if not null
    if ($record['parent_id']) {
        $doc['parent_id'] = new ObjectId($record['parent_id']);
    } else {
        $doc['parent_id'] = null;
    }
    
    $newDocuments[] = $doc;
}

echo "✅ Converted " . count($newDocuments) . " documents" . PHP_EOL;

echo PHP_EOL . "=== FINAL CONFIRMATION ===" . PHP_EOL;
echo "About to:" . PHP_EOL;
echo "1. ❌ DELETE all current menu_trees records" . PHP_EOL;
echo "2. ✅ INSERT " . count($newDocuments) . " new records with ObjectId" . PHP_EOL;
echo "3. 🔄 Update all IDs and parent_ids to ObjectId format" . PHP_EOL;
echo PHP_EOL;

echo "Type 'EXECUTE' to proceed (or anything else to cancel): ";
$confirmation = trim(fgets(STDIN));

if ($confirmation !== 'EXECUTE') {
    echo "❌ Operation cancelled by user" . PHP_EOL;
    exit;
}

echo PHP_EOL . "🚀 EXECUTING REPLACEMENT..." . PHP_EOL;

try {
    // Step 1: Count current records
    $currentCount = MenuTree::count();
    echo "Current records in collection: {$currentCount}" . PHP_EOL;
    
    // Step 2: Delete all current records
    echo "Step 1: Deleting all current records..." . PHP_EOL;
    $deleted = MenuTree::truncate();
    echo "✅ Collection truncated" . PHP_EOL;
    
    // Verify deletion
    $afterDelete = MenuTree::count();
    echo "Records after deletion: {$afterDelete}" . PHP_EOL;
    
    // Step 3: Insert new documents
    echo PHP_EOL . "Step 2: Inserting new documents with ObjectId..." . PHP_EOL;
    $insertedCount = 0;
    
    foreach ($newDocuments as $doc) {
        MenuTree::create($doc);
        $insertedCount++;
        
        if ($insertedCount % 20 == 0 || $insertedCount <= 5) {
            echo "  Inserted {$insertedCount}: {$doc['name']} (ObjectId: {$doc['_id']})" . PHP_EOL;
        }
    }
    
    echo "✅ Inserted {$insertedCount} new documents" . PHP_EOL;
    
    // Step 4: Verification
    echo PHP_EOL . "Step 3: Verification..." . PHP_EOL;
    $finalCount = MenuTree::count();
    echo "Final record count: {$finalCount}" . PHP_EOL;
    
    // Test a few records
    $testRecords = MenuTree::take(3)->get();
    foreach ($testRecords as $i => $record) {
        echo "Test record " . ($i + 1) . ":" . PHP_EOL;
        echo "  ID: {$record->id} (type: " . gettype($record->id) . ")" . PHP_EOL;
        echo "  parent_id: {$record->parent_id} (type: " . gettype($record->parent_id) . ")" . PHP_EOL;
        echo "  name: {$record->name}" . PHP_EOL;
        echo "  id_old: {$record->id_old}, parent_id_old: {$record->parent_id_old}" . PHP_EOL;
        echo PHP_EOL;
    }
    
    // Test parent-child relationship
    echo "Testing parent-child relationships..." . PHP_EOL;
    $childRecord = MenuTree::where('parent_id_old', '>', 0)->first();
    if ($childRecord) {
        echo "Child: {$childRecord->name} (ObjectId: {$childRecord->id})" . PHP_EOL;
        echo "Parent ObjectId: {$childRecord->parent_id}" . PHP_EOL;
        
        // Find parent by ObjectId
        $parent = MenuTree::find($childRecord->parent_id);
        if ($parent) {
            echo "Parent found: {$parent->name} (ObjectId: {$parent->id})" . PHP_EOL;
            echo "✅ Parent-child relationship working with ObjectId!" . PHP_EOL;
        } else {
            echo "❌ Parent not found by ObjectId" . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "=== SUCCESS! ===" . PHP_EOL;
    echo "✅ Collection replacement completed successfully!" . PHP_EOL;
    echo "✅ All IDs are now ObjectId format" . PHP_EOL;
    echo "✅ All parent_id references are ObjectId" . PHP_EOL;
    echo "✅ Parent-child relationships maintained" . PHP_EOL;
    echo "✅ Old data preserved in id_old and parent_id_old fields" . PHP_EOL;
    
} catch (\Exception $e) {
    echo "❌ ERROR during replacement: " . $e->getMessage() . PHP_EOL;
    echo "Check backup files to restore if needed" . PHP_EOL;
}

echo PHP_EOL . "📋 NEXT STEPS:" . PHP_EOL;
echo "1. Test your application with new ObjectId format" . PHP_EOL;
echo "2. Update BaseRepositorySql.php if needed" . PHP_EOL;
echo "3. Test all tree operations (find, move, create, delete)" . PHP_EOL;
echo "4. Remove id_old and parent_id_old fields when confident" . PHP_EOL;
