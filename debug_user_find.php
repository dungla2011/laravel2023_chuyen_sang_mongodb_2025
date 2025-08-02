<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "🔍 DEBUG USER::FIND(1) TRONG MONGODB\n";
echo "====================================\n\n";

try {
    // Check connection
    $userModel = new User();
    $connection = $userModel->getConnection();
    echo "🔧 Connection Info:\n";
    echo "   Type: " . get_class($connection) . "\n";
    echo "   Database: " . $connection->getDatabaseName() . "\n";
    echo "   Collection: " . $userModel->getTable() . "\n\n";

    // 1. Check total users
    echo "📊 KIỂM TRA TỔNG QUAN:\n";
    $totalUsers = User::count();
    echo "   Tổng số users: {$totalUsers}\n\n";

    // 2. Try find(1)
    echo "🔍 TEST User::find(1):\n";
    $user1 = User::find(1);
    if ($user1) {
        echo "   ✅ Tìm thấy user ID 1:\n";
        echo "   📧 Email: {$user1->email}\n";
        echo "   👤 Name: {$user1->name}\n";
        echo "   🆔 ID: {$user1->id}\n";
        echo "   🆔 _id: {$user1->_id}\n\n";
    } else {
        echo "   ❌ KHÔNG tìm thấy user ID 1\n\n";
    }

    // 3. Check first few users with their IDs
    echo "📋 DANH SÁCH USERS ĐẦU TIÊN:\n";
    $users = User::take(10)->get();
    foreach ($users as $index => $user) {
        echo "   " . ($index + 1) . ". ID: {$user->id} | _id: {$user->_id} | Email: {$user->email}\n";
    }
    echo "\n";

    // 4. Try different find methods
    echo "🧪 THỬ CÁC CÁCH TÌM KHÁC:\n";
    
    // Try with _id field
    echo "   1. User::where('_id', 1)->first():\n";
    $userById = User::where('_id', 1)->first();
    if ($userById) {
        echo "      ✅ Tìm thấy với _id = 1\n";
    } else {
        echo "      ❌ Không tìm thấy với _id = 1\n";
    }

    // Try with id field
    echo "   2. User::where('id', 1)->first():\n";
    $userByIdField = User::where('id', 1)->first();
    if ($userByIdField) {
        echo "      ✅ Tìm thấy với id = 1\n";
    } else {
        echo "      ❌ Không tìm thấy với id = 1\n";
    }

    // Check what IDs actually exist
    echo "\n🔢 CÁC ID THỰC SỰ TỒN TẠI:\n";
    $userIds = User::pluck('id')->take(10)->toArray();
    echo "   Field 'id': " . implode(', ', $userIds) . "\n";
    
    $userObjectIds = User::pluck('_id')->take(10)->toArray();
    echo "   Field '_id': " . implode(', ', $userObjectIds) . "\n\n";

    // 5. Try finding first user
    echo "🎯 FIND FIRST USER:\n";
    $firstUser = User::first();
    if ($firstUser) {
        echo "   ✅ First user found:\n";
        echo "   📧 Email: {$firstUser->email}\n";
        echo "   👤 Name: {$firstUser->name}\n";
        echo "   🆔 ID: {$firstUser->id}\n";
        echo "   🆔 _id: {$firstUser->_id}\n";
        
        // Try finding this user by its actual ID
        echo "\n   🧪 Test find với ID thực tế:\n";
        $testFind = User::find($firstUser->id);
        if ($testFind) {
            echo "      ✅ User::find({$firstUser->id}) works!\n";
        } else {
            echo "      ❌ User::find({$firstUser->id}) failed!\n";
        }
    } else {
        echo "   ❌ Không có user nào!\n";
    }

    // 6. Raw MongoDB query
    echo "\n🔧 RAW MONGODB QUERY:\n";
    $mongoDatabase = $connection->getMongoDB();
    $collection = $mongoDatabase->selectCollection('users');
    
    echo "   📊 Document count: " . $collection->countDocuments() . "\n";
    
    // Find one document
    $oneDoc = $collection->findOne();
    if ($oneDoc) {
        echo "   📄 Sample document structure:\n";
        foreach ($oneDoc as $key => $value) {
            $type = gettype($value);
            $valueStr = is_object($value) ? get_class($value) : (string)$value;
            echo "      {$key}: {$valueStr} ({$type})\n";
        }
    }

} catch (\Exception $e) {
    echo "❌ LỖI: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n\n";
    echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n🎯 Debug hoàn tất!\n";
