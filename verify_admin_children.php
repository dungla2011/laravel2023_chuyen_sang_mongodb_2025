<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "=== VERIFY ADMIN MENU CHILDREN ===\n";

// Find Admin Menu
$adminMenu = MenuTree::where('old_id', 4)->first();
if ($adminMenu) {
    echo "Admin Menu found: '{$adminMenu->name}' (ObjectId: {$adminMenu->_id})\n\n";
    
    // Find children by parent_id
    $children = MenuTree::where('parent_id', (string)$adminMenu->_id)->get();
    echo "Children found by ObjectId {$adminMenu->_id}: " . $children->count() . "\n";
    
    foreach ($children as $child) {
        echo "  - {$child->name} (old_id: {$child->old_id})\n";
    }
    
    echo "\n=== SAMPLE PARENT_ID VALUES ===\n";
    $sample = MenuTree::whereNotNull('parent_id')->take(5)->get();
    foreach ($sample as $record) {
        echo "Record: '{$record->name}'\n";
        echo "  - parent_id: '{$record->parent_id}' (type: " . gettype($record->parent_id) . ")\n";
        echo "  - length: " . strlen($record->parent_id) . "\n";
    }
    
    echo "\nAdmin Menu ObjectId: '{$adminMenu->_id}' (type: " . gettype($adminMenu->_id) . ")\n";
    echo "Admin Menu ObjectId length: " . strlen((string)$adminMenu->_id) . "\n";
    
    // Try different comparison methods
    echo "\n=== COMPARISON TESTS ===\n";
    $adminOid = (string)$adminMenu->_id;
    foreach ($sample as $record) {
        $parentOid = $record->parent_id;
        echo "Parent '{$parentOid}' == Admin '{$adminOid}': " . ($parentOid === $adminOid ? 'YES' : 'NO') . "\n";
    }
    
} else {
    echo "Admin Menu not found!\n";
}
?>
