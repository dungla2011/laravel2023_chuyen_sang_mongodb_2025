<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "=== FIX PARENT-CHILD RELATIONSHIPS ===" . PHP_EOL;

// Step 1: Build correct mapping from id_old to current ObjectId
echo "Step 1: Building correct ID mapping..." . PHP_EOL;
$allRecords = MenuTree::all();
$correctMapping = [];

foreach ($allRecords as $record) {
    $correctMapping[$record->id_old] = $record->id;
}

echo "✅ Built mapping for " . count($correctMapping) . " records" . PHP_EOL;

// Step 2: Fix parent_id references
echo PHP_EOL . "Step 2: Fixing parent_id references..." . PHP_EOL;
$fixedCount = 0;

foreach ($allRecords as $record) {
    if ($record->parent_id_old && $record->parent_id_old > 0) {
        // Tìm correct parent ObjectId
        if (isset($correctMapping[$record->parent_id_old])) {
            $correctParentId = $correctMapping[$record->parent_id_old];
            
            // Chỉ update nếu khác
            if ($record->parent_id !== $correctParentId) {
                $record->parent_id = $correctParentId;
                $record->save();
                $fixedCount++;
                
                if ($fixedCount <= 5) {
                    echo "  Fixed: {$record->name} -> parent_id: {$correctParentId}" . PHP_EOL;
                }
            }
        } else {
            echo "⚠️  Warning: Parent ID {$record->parent_id_old} not found for {$record->name}" . PHP_EOL;
        }
    }
}

echo "✅ Fixed {$fixedCount} parent_id references" . PHP_EOL;

// Step 3: Verification
echo PHP_EOL . "Step 3: Verification..." . PHP_EOL;

$testChild = MenuTree::where('parent_id_old', '>', 0)->first();
if ($testChild) {
    echo "Test child: {$testChild->name}" . PHP_EOL;
    echo "Child ID: {$testChild->id}" . PHP_EOL;
    echo "Parent ID: {$testChild->parent_id}" . PHP_EOL;
    
    $parent = MenuTree::find($testChild->parent_id);
    if ($parent) {
        echo "✅ Parent found: {$parent->name}" . PHP_EOL;
        echo "✅ Parent-child relationship working!" . PHP_EOL;
    } else {
        echo "❌ Parent still not found" . PHP_EOL;
    }
}

// Count valid relationships
$totalChildren = MenuTree::where('parent_id_old', '>', 0)->count();
$validRelationships = 0;

foreach (MenuTree::where('parent_id_old', '>', 0)->get() as $child) {
    if ($child->parent_id && MenuTree::find($child->parent_id)) {
        $validRelationships++;
    }
}

echo PHP_EOL . "📊 Final statistics:" . PHP_EOL;
echo "Total children: {$totalChildren}" . PHP_EOL;
echo "Valid relationships: {$validRelationships}" . PHP_EOL;
echo "Success rate: " . round(($validRelationships / $totalChildren) * 100, 1) . "%" . PHP_EOL;

echo PHP_EOL . "✅ Parent-child relationship fix completed!" . PHP_EOL;
