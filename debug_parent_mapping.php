<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "=== DEBUG PARENT MAPPING ===\n";

// Check what was actually inserted
$allRecords = MenuTree::all();
echo "Total records in database: " . $allRecords->count() . "\n\n";

// Get first few records to see their old_id values
echo "Sample records with old_id:\n";
$sample = MenuTree::take(10)->get();
foreach ($sample as $record) {
    echo "- ID: {$record->_id}, old_id: {$record->old_id} (type: " . gettype($record->old_id) . "), name: '{$record->name}'\n";
}

echo "\n=== CHECKING SPECIFIC PARENT IDs ===\n";
$parentIds = [1, 3, 4, 89, 260, 262, 18, 34, 30, 44, 72, 261, 543, 233, 243, 237, 307, 318, 394, 320, 38, 382, 412, 416, 479];

foreach ($parentIds as $pid) {
    $found = MenuTree::where('old_id', $pid)->first();
    if ($found) {
        echo "✓ Parent ID $pid found: '{$found->name}' (ObjectId: {$found->_id})\n";
    } else {
        echo "✗ Parent ID $pid NOT FOUND\n";
    }
}

echo "\n=== READING SQL TO CHECK INSERTION ORDER ===\n";
$content = file_get_contents(__DIR__ . '/public/tool/menu_tree.sql');
if (preg_match_all('/INSERT INTO `menu_tree`[^;]+;/i', $content, $matches)) {
    echo "Found " . count($matches[0]) . " INSERT statements\n";
    
    // Parse first few inserts to see the order
    echo "First 10 insert statements:\n";
    for ($i = 0; $i < min(10, count($matches[0])); $i++) {
        $insert = $matches[0][$i];
        if (preg_match('/VALUES \((\d+),[^,]*,\'([^\']*)\'/i', $insert, $valueMatch)) {
            $id = $valueMatch[1];
            $name = $valueMatch[2];
            echo "  $i: ID=$id, Name='$name'\n";
        }
    }
}
?>
