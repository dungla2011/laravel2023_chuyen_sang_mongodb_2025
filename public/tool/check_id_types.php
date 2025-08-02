<?php 

require_once __DIR__ . '/../../vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== ANALYZING MONGODB ID TYPES ===" . PHP_EOL;

// Test với object có parent_id
$obj = MenuTree::find(546);
if ($obj) {
    echo "Object found:" . PHP_EOL;
    echo "ID: '{$obj->id}' (type: " . gettype($obj->id) . ")" . PHP_EOL;
    echo "parent_id: '{$obj->parent_id}' (type: " . gettype($obj->parent_id) . ")" . PHP_EOL;
    
    // Kiểm tra parent object
    if ($obj->parent_id) {
        echo PHP_EOL . "Checking parent object..." . PHP_EOL;
        
        // Test find với integer
        $parent1 = MenuTree::find($obj->parent_id);
        echo "find(\$obj->parent_id) - type " . gettype($obj->parent_id) . ": " . ($parent1 ? "FOUND" : "NOT FOUND") . PHP_EOL;
        
        // Test find với string
        $parent2 = MenuTree::find((string)$obj->parent_id);
        echo "find((string)\$obj->parent_id): " . ($parent2 ? "FOUND" : "NOT FOUND") . PHP_EOL;
        
        if ($parent1) {
            echo "Parent ID: '{$parent1->id}' (type: " . gettype($parent1->id) . ")" . PHP_EOL;
        }
    }
}

echo PHP_EOL . "=== TESTING DIFFERENT ID SCENARIOS ===" . PHP_EOL;

// Lấy một vài objects để xem pattern
$objects = MenuTree::take(5)->get();
foreach ($objects as $k => $obj) {
    echo "Object $k: ID='{$obj->id}' (type: " . gettype($obj->id) . "), parent_id='{$obj->parent_id}' (type: " . gettype($obj->parent_id) . ")" . PHP_EOL;
}

echo PHP_EOL . "=== CHECKING RAW MONGODB DATA ===" . PHP_EOL;

// Kiểm tra dữ liệu thô từ MongoDB
try {
    $raw = DB::connection('mongodb')->collection('menu_trees')->find(['_id' => 546]);
    if ($raw) {
        echo "Raw MongoDB document:" . PHP_EOL;
        echo "_id type: " . gettype($raw['_id']) . PHP_EOL;
        echo "parent_id type: " . gettype($raw['parent_id']) . PHP_EOL;
        echo "Raw data: " . json_encode($raw, JSON_PRETTY_PRINT) . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error accessing raw MongoDB: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== ANALYSIS ===" . PHP_EOL;
echo "In MongoDB Laravel, there are different scenarios for ID types:" . PHP_EOL;
echo "1. ObjectId: MongoDB's default _id type (12-byte identifier)" . PHP_EOL;
echo "2. String: Custom string IDs" . PHP_EOL;
echo "3. Integer: Auto-increment IDs (rare in MongoDB)" . PHP_EOL;
echo "4. For parent_id fields: Usually same type as the primary ID" . PHP_EOL;
