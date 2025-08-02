<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "🔍 TEST USER::FIND(1) AFTER FIX\n";
echo "================================\n\n";

try {
    echo "🧪 Test User::find(1):\n";
    $user1 = User::find(1);
    
    if ($user1) {
        echo "   ✅ SUCCESS! User::find(1) works now!\n";
        echo "   📧 Email: {$user1->email}\n";
        echo "   👤 Name: " . ($user1->name ?: 'N/A') . "\n";
        echo "   🆔 ID: {$user1->id}\n";
        echo "   🆔 _id: {$user1->_id}\n";
        echo "   🔑 Primary Key: " . $user1->getKeyName() . "\n";
        echo "   📄 Model: " . get_class($user1) . "\n\n";
    } else {
        echo "   ❌ Still not working!\n\n";
    }

    // Test a few more IDs
    echo "🔢 Test more IDs:\n";
    $testIds = [1, 2, 9, 10];
    foreach ($testIds as $id) {
        $user = User::find($id);
        if ($user) {
            echo "   ✅ User::find({$id}): {$user->email}\n";
        } else {
            echo "   ❌ User::find({$id}): Not found\n";
        }
    }

    echo "\n🎯 Test với string ID:\n";
    $userStr = User::find('1');
    if ($userStr) {
        echo "   ✅ User::find('1') works: {$userStr->email}\n";
    } else {
        echo "   ❌ User::find('1') failed\n";
    }

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
}

echo "\n🎯 Test completed!\n";
