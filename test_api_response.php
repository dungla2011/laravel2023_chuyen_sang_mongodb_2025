<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

require_once 'app/common.php';

use App\Models\MenuTree;

// Test API response format
echo "Testing API response format...\n";

$menuTree = MenuTree::select('id', 'name', 'parent_id', 'has_child', 'link', 'gid_allow', 'created_at')
    ->take(10)
    ->get();

$response = [
    'code' => 1,
    'payload' => $menuTree->toArray()
];

echo "Sample API response:\n";
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "\n\nAnalyzing toArray() conversion:\n";
foreach ($menuTree as $item) {
    $array = $item->toArray();
    echo "- {$item->name}:\n";
    echo "  parent_id in object: " . ($item->parent_id ? $item->parent_id : 'NULL') . " (type: " . gettype($item->parent_id) . ")\n";
    echo "  parent_id in array: " . ($array['parent_id'] ? $array['parent_id'] : 'NULL') . " (type: " . gettype($array['parent_id']) . ")\n\n";
}
