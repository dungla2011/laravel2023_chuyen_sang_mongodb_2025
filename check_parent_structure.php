<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

require_once 'app/common.php';

use App\Models\MenuTree;

echo "Checking parent_id values in database...\n";

// Get some samples to see parent_id values
$samples = MenuTree::select('id', 'name', 'parent_id')
    ->take(10)
    ->get();

echo "Sample records:\n";
foreach ($samples as $item) {
    $pid = $item->parent_id;
    echo "- {$item->name}:\n";
    echo "  parent_id = '" . ($pid ?? 'NULL') . "' (type: " . gettype($pid) . ")\n";
    echo "  length: " . (is_string($pid) ? strlen($pid) : 'N/A') . "\n";
    echo "  empty check: " . (empty($pid) ? 'true' : 'false') . "\n\n";
}

echo "\nParent_id statistics:\n";
$total = MenuTree::count();
$nullCount = MenuTree::whereNull('parent_id')->count();
$emptyStringCount = MenuTree::where('parent_id', '')->count();
$nonEmptyCount = MenuTree::where('parent_id', '!=', '')
    ->whereNotNull('parent_id')
    ->count();

echo "- Total records: {$total}\n";
echo "- NULL parent_id: {$nullCount}\n";
echo "- Empty string parent_id: {$emptyStringCount}\n";
echo "- Non-empty parent_id: {$nonEmptyCount}\n";

// Check if there are any actual parent-child relationships
echo "\nChecking for parent-child relationships:\n";
$withNonEmptyParent = MenuTree::where('parent_id', '!=', '')
    ->whereNotNull('parent_id')
    ->take(5)
    ->get();

foreach ($withNonEmptyParent as $item) {
    $parentExists = MenuTree::where('id', $item->parent_id)->exists();
    echo "- {$item->name} -> parent_id: '{$item->parent_id}' (parent exists: " . ($parentExists ? 'YES' : 'NO') . ")\n";
}
