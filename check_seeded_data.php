<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DATABASE SEEDING REPORT ===\n\n";

$models = [
    'BlockUi',
    'MenuTree', 
    'Menu',
    'DemoTbl',
    'DemoFolderTbl',
    'DemoAndTagTbl',
    'Category',
    'Product',
    'ProductFolder',
    'ProductTag',
    'ProductImage',
    'Cart',
    'CartItem'
];

$totalRecords = 0;

foreach ($models as $model) {
    try {
        $modelClass = "\\App\\Models\\{$model}";
        if (class_exists($modelClass)) {
            $count = $modelClass::count();
            $totalRecords += $count;
            echo sprintf("%-20s: %d records\n", $model, $count);
            
            // Show sample data for some models
            if ($count > 0 && in_array($model, ['BlockUi', 'MenuTree', 'Product'])) {
                $sample = $modelClass::first();
                echo sprintf("  Sample: %s\n", $sample->name ?? $sample->_id ?? 'N/A');
            }
        } else {
            echo sprintf("%-20s: Model not found\n", $model);
        }
    } catch (\Exception $e) {
        echo sprintf("%-20s: Error - %s\n", $model, $e->getMessage());
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total models checked: " . count($models) . "\n";
echo "Total records seeded: {$totalRecords}\n";

// Test some relationships
echo "\n=== SAMPLE DATA ===\n";

try {
    $blockUi = \App\Models\BlockUi::first();
    if ($blockUi) {
        echo "First BlockUi:\n";
        echo "- ID: {$blockUi->_id}\n";
        echo "- Name: {$blockUi->name}\n";
        echo "- SName: {$blockUi->sname}\n";
        echo "- Status: {$blockUi->status}\n";
    }
} catch (\Exception $e) {
    echo "Error getting BlockUi sample: " . $e->getMessage() . "\n";
}

try {
    $menuTree = \App\Models\MenuTree::first();
    if ($menuTree) {
        echo "\nFirst MenuTree:\n";
        echo "- ID: {$menuTree->_id}\n";
        echo "- Name: {$menuTree->name}\n";
        echo "- Link: {$menuTree->link}\n";
        echo "- Parent ID: {$menuTree->parent_id}\n";
    }
} catch (\Exception $e) {
    echo "Error getting MenuTree sample: " . $e->getMessage() . "\n";
}

try {
    $product = \App\Models\Product::first();
    if ($product) {
        echo "\nFirst Product:\n";
        echo "- ID: {$product->_id}\n";
        echo "- Name: {$product->name}\n";
        echo "- Type: {$product->type}\n";
        echo "- Price: {$product->price}\n";
    }
} catch (\Exception $e) {
    echo "Error getting Product sample: " . $e->getMessage() . "\n";
}

echo "\n=== END REPORT ===\n";
