<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

require_once 'app/common.php';

use App\Models\MenuTree;

echo "Checking parent_id structure...\n";

// Get some samples with different parent_id values
$samples = MenuTree::select('id', 'name', 'parent_id')
    ->take(10)
    ->get();

echo "Sample records:\n";
foreach ($samples as $item) {
    $pid = $item->parent_id ?: 'NULL';
    echo "- {$item->name} (parent_id: {$pid})\n";
}

echo "\nParent_id value analysis:\n";
$nullCount = MenuTree::whereNull('parent_id')->count();
$zeroCount = MenuTree::where('parent_id', '0')->count();
$emptyCount = MenuTree::where('parent_id', '')->count();
$nonEmptyCount = MenuTree::whereNotNull('parent_id')
    ->where('parent_id', '!=', '')
    ->where('parent_id', '!=', '0')
    ->count();

echo "- NULL parent_id: {$nullCount}\n";
echo "- '0' parent_id: {$zeroCount}\n"; 
echo "- Empty string parent_id: {$emptyCount}\n";
echo "- Non-empty parent_id: {$nonEmptyCount}\n";

// Check if parent_id values are valid ObjectIds
echo "\nChecking parent_id ObjectId validity:\n";
$withParent = MenuTree::whereNotNull('parent_id')
    ->where('parent_id', '!=', '')
    ->where('parent_id', '!=', '0')
    ->take(5)
    ->get();

foreach ($withParent as $item) {
    $parentExists = MenuTree::where('id', $item->parent_id)->exists();
    echo "- {$item->name} -> parent_id: {$item->parent_id} (exists: " . ($parentExists ? 'YES' : 'NO') . ")\n";
}
