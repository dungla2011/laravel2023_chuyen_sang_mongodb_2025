<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;

echo "Debugging old_id values in database...\n\n";

// Check what old_id values were actually stored
$samples = MenuTree::select('old_id', 'name')->take(10)->get();

echo "Sample records with old_id values:\n";
foreach ($samples as $record) {
    echo "- Name: '{$record->name}', old_id: '{$record->old_id}' (type: " . gettype($record->old_id) . ")\n";
}

echo "\nChecking specific IDs:\n";
$ids = [1, 3, 4, 89, 260];
foreach ($ids as $id) {
    $found = MenuTree::where('old_id', $id)->first();
    if ($found) {
        echo "✓ Found old_id $id: '{$found->name}'\n";
    } else {
        echo "✗ NOT found old_id $id\n";
    }
}

echo "\nChecking as string:\n";
foreach ($ids as $id) {
    $found = MenuTree::where('old_id', (string)$id)->first();
    if ($found) {
        echo "✓ Found old_id '$id' (as string): '{$found->name}'\n";
    } else {
        echo "✗ NOT found old_id '$id' (as string)\n";
    }
}
