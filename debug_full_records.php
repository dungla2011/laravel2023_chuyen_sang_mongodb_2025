<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "=== DEBUG FULL RECORD COUNT ===\n";

// Count with SoftDeletes (only active)
$activeCount = MenuTree::count();
echo "Active records (SoftDeletes enabled): $activeCount\n";

// Count without SoftDeletes (all records)
$allCount = MenuTree::withTrashed()->count();
echo "All records (including deleted): $allCount\n";

// Get deleted records
$deletedCount = MenuTree::onlyTrashed()->count();
echo "Deleted records: $deletedCount\n\n";

echo "=== CHECKING PARENT IDs IN ALL RECORDS ===\n";
$parentIds = [34, 30, 44, 72, 243, 382];

foreach ($parentIds as $pid) {
    // Check in active records
    $active = MenuTree::where('old_id', $pid)->first();
    // Check in all records (including deleted)
    $all = MenuTree::withTrashed()->where('old_id', $pid)->first();
    
    if ($active) {
        echo "✓ Parent ID $pid found (ACTIVE): '{$active->name}'\n";
    } elseif ($all) {
        echo "⚠ Parent ID $pid found (DELETED): '{$all->name}'\n";
    } else {
        echo "✗ Parent ID $pid NOT FOUND anywhere\n";
    }
}

echo "\n=== ID MAPPING BUILD ISSUE ===\n";
echo "The issue is likely that the script inserts ALL records (including deleted),\n";
echo "but only builds relationships for active ones, creating orphans.\n";
?>
