<?php
// MongoDB Replica Set Initializer từ PHP - Simplified version
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

try {
    echo "🔧 Kết nối đến MongoDB...\n";
    $client = new Client('mongodb://localhost:27017');
    echo "✅ Đã kết nối đến MongoDB thành công\n";
    
    echo "🔧 Khởi tạo replica set...\n";
    $adminDb = $client->selectDatabase('admin');
    
    // Khởi tạo replica set
    $config = [
        '_id' => 'rs0',
        'members' => [
            [
                '_id' => 0,
                'host' => 'localhost:27017'
            ]
        ]
    ];
    
    try {
        $result = $adminDb->command(['replSetInitiate' => $config]);
        $resultArray = $result->toArray();
        
        if (isset($resultArray[0]['ok']) && $resultArray[0]['ok'] == 1) {
            echo "✅ Replica set đã được khởi tạo thành công!\n";
            echo "🎉 MongoDB hiện đã hỗ trợ transactions!\n";
            
            echo "🔧 Đợi replica set ổn định (10 giây)...\n";
            sleep(10);
            
            echo "🔧 Test transaction...\n";
            testTransaction($client);
            
        } else {
            echo "⚠️ Kết quả khởi tạo: " . json_encode($resultArray[0]) . "\n";
        }
        
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'already initialized') !== false) {
            echo "✅ Replica set đã được khởi tạo trước đó\n";
            echo "🎉 MongoDB đã hỗ trợ transactions!\n";
            
            echo "🔧 Test transaction...\n";
            testTransaction($client);
        } else {
            echo "❌ Lỗi: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi kết nối MongoDB: " . $e->getMessage() . "\n";
}

function testTransaction($client) {
    try {
        echo "🔧 Bắt đầu test transaction...\n";
        
        // Start session
        $session = $client->startSession();
        $session->startTransaction();
        
        // Insert test document
        $testDb = $client->selectDatabase('test');
        $collection = $testDb->selectCollection('transaction_test');
        
        $result = $collection->insertOne([
            'test' => 'transaction_support',
            'timestamp' => time(),
            'message' => 'Laravel MongoDB transactions work!',
            'created_at' => date('Y-m-d H:i:s')
        ], ['session' => $session]);
        
        // Commit transaction
        $session->commitTransaction();
        $session->endSession();
        
        echo "✅ TRANSACTIONS HOẠT ĐỘNG BÌNH THƯỜNG!\n";
        echo "🎉 Laravel có thể sử dụng MongoDB transactions\n";
        echo "📝 Đã tạo test document với ID: " . $result->getInsertedId() . "\n";
        
    } catch (Exception $e) {
        echo "❌ Lỗi test transaction: " . $e->getMessage() . "\n";
        
        if (strpos($e->getMessage(), 'Transaction numbers') !== false) {
            echo "💡 Replica set có thể chưa hoàn toàn sẵn sàng, hãy thử lại sau vài phút\n";
        }
    }
}

echo "\n🎯 Script hoàn tất!\n";
echo "🔧 Bây giờ bạn có thể sử dụng transactions trong Laravel\n";
?>
