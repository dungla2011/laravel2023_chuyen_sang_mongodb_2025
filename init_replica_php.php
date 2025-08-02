<?php
// MongoDB Replica Set Initializer từ PHP
// Khởi tạo replica set trực tiếp từ MongoDB PHP driver

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

try {
    echo "🔧 Kết nối đến MongoDB...\n";
    
    // Kết nối đến MongoDB
    $client = new Client('mongodb://localhost:27017');
    
    echo "✅ Đã kết nối đến MongoDB thành công\n";
    
    // Kiểm tra xem replica set đã được khởi tạo chưa
    echo "🔧 Kiểm tra trạng thái replica set hiện tại...\n";
    
    try {
        $adminDb = $client->selectDatabase('admin');
        $result = $adminDb->command(['replSetGetStatus' => 1]);
        $resultArray = $result->toArray()[0];
        
        echo "✅ Replica set đã được khởi tạo: " . $resultArray['set'] . "\n";
        echo "✅ Trạng thái: " . $resultArray['myState'] . "\n";
        echo "🎉 MONGODB ĐÃ HỖ TRỢ TRANSACTIONS!\n";
        
        // Test transaction
        echo "\n🔧 Test transaction...\n";
        testTransaction($client);
        
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'no replset config') !== false) {
            echo "⚠️  Replica set chưa được khởi tạo - bắt đầu khởi tạo...\n";
            
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
            
            echo "🔧 Khởi tạo replica set với config: rs0\n";
            $result = $adminDb->command(['replSetInitiate' => $config]);
            
            if ($result['ok'] == 1) {
                echo "✅ Replica set đã được khởi tạo thành công!\n";
                echo "🎉 MongoDB hiện đã hỗ trợ transactions!\n";
                
                // Đợi replica set ổn định
                echo "🔧 Đợi replica set ổn định...\n";
                sleep(5);
                
                // Kiểm tra lại trạng thái
                $statusResult = $adminDb->command(['replSetGetStatus' => 1]);
                $statusArray = $statusResult->toArray()[0];
                echo "✅ Xác nhận replica set hoạt động: " . $statusArray['set'] . "\n";
                
                foreach ($statusArray['members'] as $member) {
                    echo "   - " . $member['name'] . " (" . $member['stateStr'] . ")\n";
                }
                
                // Test transaction
                echo "\n🔧 Test transaction sau khi khởi tạo...\n";
                sleep(2); // Đợi thêm chút để replica set hoàn toàn sẵn sàng
                testTransaction($client);
                
            } else {
                echo "❌ Lỗi khởi tạo replica set: " . json_encode($result) . "\n";
            }
            
        } else {
            echo "❌ Lỗi khác: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi kết nối MongoDB: " . $e->getMessage() . "\n";
    echo "💡 Đảm bảo MongoDB service đang chạy\n";
}

function testTransaction($client) {
    try {
        // Bắt đầu session để test transaction
        $session = $client->startSession();
        
        // Bắt đầu transaction
        $session->startTransaction();
        
        // Thực hiện một operation đơn giản trong transaction
        $testDb = $client->selectDatabase('test');
        $collection = $testDb->selectCollection('transaction_test');
        
        $collection->insertOne([
            'test' => 'transaction_support',
            'timestamp' => time(),
            'message' => 'Laravel MongoDB transactions work!'
        ], ['session' => $session]);
        
        // Commit transaction
        $session->commitTransaction();
        $session->endSession();
        
        echo "✅ TRANSACTIONS HOẠT ĐỘNG BÌNH THƯỜNG!\n";
        echo "🎉 Laravel có thể sử dụng MongoDB transactions\n";
        
    } catch (Exception $e) {
        echo "❌ Lỗi test transaction: " . $e->getMessage() . "\n";
        
        if (strpos($e->getMessage(), 'Transaction numbers') !== false) {
            echo "💡 Cần đợi replica set hoàn toàn sẵn sàng\n";
        }
    }
}

echo "\n🎯 Script hoàn tất!\n";
?>
