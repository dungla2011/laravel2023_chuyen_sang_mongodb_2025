<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MenuTree;

echo "Debugging Admin Menu children...\n";

// Find Admin Menu record
$adminMenu = MenuTree::withTrashed()->where('old_id', 4)->first();
if (!$adminMenu) {
    die("Admin Menu not found!\n");
}

echo "Admin Menu: '{$adminMenu->name}' (ObjectId: {$adminMenu->_id})\n";
echo "Deleted at: " . ($adminMenu->deleted_at ?: 'NOT DELETED') . "\n\n";

// Find all children by ObjectId (including deleted)
$allChildren = MenuTree::withTrashed()->where('parent_id', $adminMenu->_id)->get();
echo "Total children found: " . $allChildren->count() . "\n\n";

if ($allChildren->count() > 0) {
    echo "Children details:\n";
    foreach ($allChildren as $child) {
        $status = $child->deleted_at ? 'DELETED' : 'ACTIVE';
        echo "- {$child->name} (old_id: {$child->old_id}) - $status\n";
    }
} else {
    echo "No children found by ObjectId. Checking by old_parent_id in records...\n";
    
    // Debug: Find records that should be children based on old_parent_id
    $expectedChildren = MenuTree::withTrashed()->where('old_parent_id', 4)->get();
    echo "Records with old_parent_id = 4: " . $expectedChildren->count() . "\n";
    
    foreach ($expectedChildren as $child) {
        $status = $child->deleted_at ? 'DELETED' : 'ACTIVE';
        echo "- {$child->name} (old_id: {$child->old_id}) - parent_id: {$child->parent_id} - $status\n";
    }
}
