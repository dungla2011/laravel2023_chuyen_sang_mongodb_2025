<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MenuTree;

echo "=== Testing MenuTree::find() with ObjectId string ===\n\n";

// Test với ID cụ thể mà user đưa ra
$testId = "688d7d5e397c13fd880fce49";

echo "1. Testing with ID: $testId\n";
$result = MenuTree::find($testId);

if ($result) {
    echo "   ✅ SUCCESS: Found record!\n";
    echo "   Name: " . $result->name . "\n";
    echo "   Parent ID: " . $result->parent_id . "\n";
    echo "   ID Type: " . gettype($result->_id) . "\n";
} else {
    echo "   ❌ NOT FOUND: Record with ID '$testId' not found\n";
    
    // Liệt kê một vài ID có sẵn để kiểm tra
    echo "\n2. Available IDs in database:\n";
    $records = MenuTree::limit(5)->get();
    foreach ($records as $record) {
        echo "   - " . $record->_id . " (" . $record->name . ")\n";
    }
}

echo "\n=== Test Complete ===\n";
