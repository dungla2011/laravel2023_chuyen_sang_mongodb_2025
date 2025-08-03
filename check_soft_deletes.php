<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MenuTree;

echo "Checking SoftDeletes effect...\n";

$total = MenuTree::withTrashed()->count();
$active = MenuTree::count();
$deleted = MenuTree::onlyTrashed()->count();

echo "Total records (including deleted): $total\n";
echo "Active records: $active\n";
echo "Deleted records: $deleted\n";

echo "\nSample deleted records:\n";
$deletedSamples = MenuTree::onlyTrashed()->take(5)->get(['name', 'deleted_at']);
foreach ($deletedSamples as $record) {
    echo "- {$record->name} (deleted: {$record->deleted_at})\n";
}

echo "\nParent-child relationships (active only):\n";
$activeRoots = MenuTree::whereNull('parent_id')->take(3)->get();
foreach ($activeRoots as $root) {
    $children = MenuTree::where('parent_id', $root->_id)->count();
    echo "- Active Root '{$root->name}' has $children active children\n";
}

echo "\nParent-child relationships (including deleted):\n";
$allRoots = MenuTree::withTrashed()->whereNull('parent_id')->take(3)->get();
foreach ($allRoots as $root) {
    $allChildren = MenuTree::withTrashed()->where('parent_id', $root->_id)->count();
    $activeChildren = MenuTree::where('parent_id', $root->_id)->count();
    echo "- Root '{$root->name}' has $allChildren total children ($activeChildren active)\n";
}
