<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use LadLib\Laravel\Database\DbHelperLaravel;
use Illuminate\Support\Facades\DB;

echo "🔍 TEST getAllTableName() METHOD FOR MONGODB\n";
echo "=============================================\n\n";

try {
    // Test connection type
    $connection = DB::connection();
    echo "🔧 Connection Info:\n";
    echo "   Type: " . get_class($connection) . "\n";
    echo "   Database: " . $connection->getDatabaseName() . "\n\n";

    // Test getAllTableName method
    echo "📊 Testing getAllTableName()...\n";
    $tables = DbHelperLaravel::getAllTableName();
    
    echo "✅ Found " . count($tables) . " collections/tables:\n\n";
    
    foreach ($tables as $index => $table) {
        echo "   " . ($index + 1) . ". {$table}\n";
    }
    
    echo "\n🧪 Raw MongoDB Collections:\n";
    if ($connection instanceof \MongoDB\Laravel\Connection) {
        $mongoDatabase = $connection->getMongoDB();
        $collections = $mongoDatabase->listCollectionNames();
        $rawCollections = iterator_to_array($collections);
        
        foreach ($rawCollections as $index => $collection) {
            echo "   " . ($index + 1) . ". {$collection} (raw)\n";
        }
    }

    echo "\n✅ Method works correctly!\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n\n";
    echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n🎯 Test completed!\n";
