<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== KIỂM TRA USER TRONG CẢ 2 DATABASE ===\n";

// Database 1: glx2023_for_testing (mặc định)
echo "1. Database: glx2023_for_testing\n";
try {
    $users1 = User::all();
    echo "Users count: " . $users1->count() . "\n";
    foreach($users1 as $user) {
        echo "- Email: " . $user->email . ", Username: " . $user->username . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n2. Database: test_2025 (web domain)\n";
try {
    // Thay đổi database connection
    config(['database.connections.mongodb.database' => 'test_2025']);
    DB::purge('mongodb');
    
    $users2 = User::all();
    echo "Users count: " . $users2->count() . "\n";
    foreach($users2 as $user) {
        echo "- Email: " . $user->email . ", Username: " . $user->username . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== TẠO USER TRONG DATABASE test_2025 ===\n";
try {
    // Đảm bảo đang dùng database test_2025
    config(['database.connections.mongodb.database' => 'test_2025']);
    DB::purge('mongodb');
    
    // Kiểm tra xem user đã tồn tại chưa
    $existingUser = User::where('email', 'admin@abc.com')->first();
    if ($existingUser) {
        echo "✅ User đã tồn tại trong test_2025: " . $existingUser->email . "\n";
        echo "🗑️ Đang xóa user cũ để tạo mới...\n";
        try {
            $existingUser->delete();
            echo "✅ Đã xóa user cũ thành công!\n";
        } catch (Exception $e) {
            echo "❌ Lỗi khi xóa user cũ: " . $e->getMessage() . "\n";
        }
    }
    
    echo "🆕 Đang tạo user admin mới...\n";
    
    $newUser = new User();
    $newUser->name = 'Administrator';
    $newUser->username = 'admin';
    $newUser->email = 'admin@abc.com';
    $newUser->password = 'admin123456';
    $newUser->phone_number = 84123456789;
    $newUser->is_admin = 1;
    $newUser->site_id = 1;
    $newUser->email_active_at = now();
    $newUser->reg_str = null;
    $newUser->log = 'Admin user created at: ' . now();
    $newUser->reset_pw = null;
    $newUser->avatar = '/images/avatar/admin.png';
    $newUser->token_user = null;
    $newUser->remember_token = null;
    $newUser->deleted_at = null;
    $newUser->save();
    
    echo "✅ Đã tạo user mới trong test_2025: " . $newUser->email . "\n";
    echo "ID: " . $newUser->_id . "\n";
    echo "Phone: " . $newUser->phone_number . "\n";
    echo "Site ID: " . $newUser->site_id . "\n";
    echo "Avatar: " . $newUser->avatar . "\n";
} catch (Exception $e) {
    echo "❌ Error creating user: " . $e->getMessage() . "\n";
}
