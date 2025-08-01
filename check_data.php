<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check data
echo "BlockUi count: " . \App\Models\BlockUi::count() . "\n";
echo "MenuTree count: " . \App\Models\MenuTree::count() . "\n";

// Show some sample data
$blockUis = \App\Models\BlockUi::take(2)->get();
echo "\nSample BlockUi data:\n";
foreach ($blockUis as $item) {
    echo "- ID: {$item->_id}, Name: {$item->name}, SName: {$item->sname}\n";
}

$menuTrees = \App\Models\MenuTree::take(3)->get();
echo "\nSample MenuTree data:\n";
foreach ($menuTrees as $item) {
    echo "- ID: {$item->_id}, Name: {$item->name}, Parent: {$item->parent_id}, Link: {$item->link}\n";
}
