<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

echo "🧪 TESTING SQL TO MONGO IMPORT\n";
echo str_repeat("=", 50) . "\n";

// Set database to test_2025
config(['database.connections.mongodb.database' => 'test_2025']);
DB::purge('mongodb');

echo "🎯 Database: test_2025\n";

// Test simple import with sample data
$testTables = [
    'assets' => [
        ['original_id' => 1, 'name' => 'Máy tính PC', 'user_id' => null, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ['original_id' => 2, 'name' => 'Máy tính Laptop', 'user_id' => null, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ],
    'asset_categories' => [
        ['original_id' => 1, 'name' => 'Thiết bị Tin học', 'parent_id' => 0, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ['original_id' => 2, 'name' => 'Thiết bị Y Tế', 'parent_id' => 0, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ],
    'block_uis' => [
        ['original_id' => 1, 'name' => 'Giới thiệu', 'status' => 1, 'content' => 'Nội dung giới thiệu...', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ['original_id' => 2, 'name' => 'Banner', 'status' => 1, 'content' => 'Nội dung banner...', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ],
    'categories' => [
        ['original_id' => 1, 'name' => 'Technology', 'slug' => 'technology', 'parent_id' => null, 'site_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ['original_id' => 2, 'name' => 'Health', 'slug' => 'health', 'parent_id' => null, 'site_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ]
];

$totalInserted = 0;

foreach ($testTables as $collectionName => $documents) {
    echo "📥 Importing to collection: $collectionName\n";
    
    try {
        $collection = DB::connection('mongodb')->table($collectionName);
        
        // Clear existing data
        $collection->truncate();
        
        // Insert documents
        $collection->insert($documents);
        
        // Verify
        $count = $collection->count();
        echo "   ✅ Inserted: " . count($documents) . " documents\n";
        echo "   📊 Verified: $count documents in collection\n";
        
        $totalInserted += count($documents);
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo str_repeat("-", 50) . "\n";
echo "📊 Total documents inserted: $totalInserted\n";
echo "✅ Test import completed!\n";

echo "\n🔍 VERIFICATION:\n";
foreach (array_keys($testTables) as $collectionName) {
    try {
        $collection = DB::connection('mongodb')->table($collectionName);
        $count = $collection->count();
        $sample = $collection->first();
        
        echo "📋 $collectionName: $count documents\n";
        if ($sample) {
            echo "   Sample: " . $sample['name'] . " (ID: " . $sample['_id'] . ")\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error checking $collectionName: " . $e->getMessage() . "\n";
    }
}
