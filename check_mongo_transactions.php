<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "🔍 KIỂM TRA MONGODB TRANSACTION SUPPORT\n";
echo "======================================\n\n";

try {
    // Get connection
    $userModel = new User();
    $connection = $userModel->getConnection();
    $mongoDatabase = $connection->getMongoDB();
    
    echo "🔧 Connection Info:\n";
    echo "   Type: " . get_class($connection) . "\n";
    echo "   Database: " . $connection->getDatabaseName() . "\n\n";

    // 1. Check MongoDB server info
    echo "📊 MONGODB SERVER INFO:\n";
    $serverStatus = $mongoDatabase->command(['serverStatus' => 1]);
    $serverInfo = $serverStatus->toArray()[0];
    
    echo "   📍 Host: " . ($serverInfo['host'] ?? 'Unknown') . "\n";
    echo "   🏷️  Version: " . ($serverInfo['version'] ?? 'Unknown') . "\n";
    echo "   🔄 Process: " . ($serverInfo['process'] ?? 'Unknown') . "\n";
    echo "   ⏰ Uptime: " . ($serverInfo['uptime'] ?? 'Unknown') . " seconds\n\n";

    // 2. Check if replica set
    echo "🔍 REPLICA SET STATUS:\n";
    try {
        $rsStatus = $mongoDatabase->command(['replSetGetStatus' => 1]);
        $rsInfo = $rsStatus->toArray()[0];
        
        echo "   ✅ This is a REPLICA SET!\n";
        echo "   🏷️  Set Name: " . ($rsInfo['set'] ?? 'Unknown') . "\n";
        echo "   👑 My State: " . ($rsInfo['myState'] ?? 'Unknown') . "\n";
        echo "   📊 Members: " . (count($rsInfo['members'] ?? [])) . "\n";
        
        if (isset($rsInfo['members'])) {
            foreach ($rsInfo['members'] as $index => $member) {
                $state = $member['stateStr'] ?? 'Unknown';
                $name = $member['name'] ?? 'Unknown';
                echo "      " . ($index + 1) . ". {$name} - {$state}\n";
            }
        }
        echo "\n   🎉 TRANSACTIONS ARE SUPPORTED!\n\n";
        
    } catch (\Exception $e) {
        echo "   ❌ This is NOT a replica set (Standalone mode)\n";
        echo "   📝 Error: " . $e->getMessage() . "\n";
        echo "   ⚠️  TRANSACTIONS ARE NOT SUPPORTED!\n\n";
    }

    // 3. Test simple transaction
    echo "🧪 TEST TRANSACTION:\n";
    try {
        DB::transaction(function () {
            $user = User::first();
            if ($user) {
                // Just a simple read operation
                echo "   📖 Read user: {$user->email}\n";
            }
        });
        echo "   ✅ Simple transaction test PASSED!\n\n";
        
    } catch (\Exception $e) {
        echo "   ❌ Transaction test FAILED!\n";
        echo "   📝 Error: " . $e->getMessage() . "\n\n";
    }

    // 4. Check transaction support with MongoDB driver directly
    echo "🔧 MONGODB DRIVER TRANSACTION TEST:\n";
    try {
        $session = $connection->getMongoClient()->startSession();
        $session->startTransaction();
        
        // Simple operation
        $collection = $mongoDatabase->selectCollection('users');
        $collection->findOne([], ['session' => $session]);
        
        $session->commitTransaction();
        $session->endSession();
        
        echo "   ✅ MongoDB driver transaction test PASSED!\n\n";
        
    } catch (\Exception $e) {
        echo "   ❌ MongoDB driver transaction test FAILED!\n";
        echo "   📝 Error: " . $e->getMessage() . "\n\n";
    }

    // 5. Configuration recommendations
    echo "💡 RECOMMENDATIONS:\n";
    try {
        $rsStatus = $mongoDatabase->command(['replSetGetStatus' => 1]);
        echo "   ✅ Your MongoDB supports transactions\n";
        echo "   🎯 You can use DB::transaction() safely\n";
    } catch (\Exception $e) {
        echo "   ⚠️  To enable transactions, you need to:\n";
        echo "      1. Convert to replica set mode\n";
        echo "      2. Or use MongoDB Atlas (cloud)\n";
        echo "      3. For development, you can initialize a single-node replica set:\n";
        echo "         rs.initiate()\n\n";
        
        echo "   🔧 Quick fix for development:\n";
        echo "      1. Connect to MongoDB shell: mongo\n";
        echo "      2. Run: rs.initiate()\n";
        echo "      3. Wait a few seconds\n";
        echo "      4. Restart your application\n\n";
    }

    // 6. Alternative without transactions
    echo "🔄 ALTERNATIVES WITHOUT TRANSACTIONS:\n";
    echo "   📝 Use atomic operations:\n";
    echo "      - findOneAndUpdate()\n";
    echo "      - findOneAndReplace()\n";
    echo "      - bulkWrite()\n";
    echo "   📝 Design schema to minimize multi-document operations\n";
    echo "   📝 Use embedded documents instead of references\n\n";

} catch (\Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n\n";
}

echo "🎯 Check completed!\n";
