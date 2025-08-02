<?php

require_once __DIR__ . '/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test the tree_create response format
try {
    echo "=== Testing tree_create Response Format ===\n";
    
    // Create a repository instance
    $model = new \App\Models\MenuTree();
    $repo = new \App\Repositories\MenuTreeRepositorySql($model);
    
    // Create mock objParam
    $objParam = new \App\Components\clsParamRequestEx();
    $objParam->need_set_uid = 1;
    $objParam->userIdLogined = 1;
    
    // Test create
    $param = [
        'new_name' => 'Debug Test - ' . date('H:i:s'),
        'pid' => 0
    ];
    
    $result = $repo->tree_create($param, $objParam);
    echo "Result type: " . get_class($result) . "\n";
    echo "Content type: " . gettype($result->getContent()) . "\n";
    echo "Raw content: " . $result->getContent() . "\n";
    
    // Try to decode
    $decoded = json_decode($result->getContent(), true);
    echo "JSON decode successful: " . (json_last_error() === JSON_ERROR_NONE ? 'Yes' : 'No') . "\n";
    echo "JSON error: " . json_last_error_msg() . "\n";
    
    if ($decoded) {
        echo "Decoded keys: " . implode(', ', array_keys($decoded)) . "\n";
        echo "Full decoded: " . print_r($decoded, true) . "\n";
    }
    
    // Clean up
    $testObjects = \App\Models\MenuTree::where('name', 'like', 'Debug Test%')->get();
    foreach ($testObjects as $obj) {
        echo "Cleaning up: " . $obj->name . " (ID: " . $obj->id . ")\n";
        $obj->delete();
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
