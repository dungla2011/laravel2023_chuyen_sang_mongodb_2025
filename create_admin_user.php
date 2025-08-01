<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Carbon\Carbon;

echo "Tạo admin user...\n";

// Kiểm tra xem đã có admin chưa
$existingAdmin = User::where('email', 'admin@abc.com')->first();
if ($existingAdmin) {
    echo "Đã có admin user: {$existingAdmin->email}\n";
    echo "ID: {$existingAdmin->_id}\n";
    echo "Username: {$existingAdmin->username}\n";
    echo "Name: {$existingAdmin->name}\n";
    echo "Created: {$existingAdmin->created_at}\n";
    
    echo "\n� Đang cập nhật password cho admin user...\n";
    try {
        $existingAdmin->password = 'admin123456'; // Password sẽ được hash tự động
        $existingAdmin->updated_at = Carbon::now();
        $existingAdmin->save();
        
        echo "✅ Đã cập nhật password admin user thành công!\n";
        echo "Email: {$existingAdmin->email}\n";
        echo "Username: {$existingAdmin->username}\n";
        echo "New Password: admin123456\n";
        echo "Updated at: {$existingAdmin->updated_at}\n\n";
        
        // Kết thúc script vì đã có admin
        return;
    } catch (Exception $e) {
        echo "❌ Lỗi khi cập nhật password admin user: " . $e->getMessage() . "\n\n";
        return;
    }
}

// Tạo admin user mới
$adminUser = new User();
$adminUser->name = 'Administrator';
$adminUser->username = 'admin';
$adminUser->email = 'admin@abc.com';
$adminUser->password = 'admin123456'; // Sẽ được hash tự động qua setPasswordAttribute
$adminUser->phone_number = 84123456789;
$adminUser->is_admin = 1;
$adminUser->site_id = 1;
$adminUser->email_active_at = Carbon::now();
$adminUser->reg_str = null; // Không cần activation string cho admin
$adminUser->log = 'Admin user created at: ' . Carbon::now();
$adminUser->reset_pw = null;
$adminUser->avatar = '/images/avatar/admin.png';
$adminUser->token_user = null; // Sẽ được set tự động nếu cần
$adminUser->remember_token = null;
$adminUser->created_at = Carbon::now();
$adminUser->updated_at = Carbon::now();
$adminUser->deleted_at = null;

try {
    $adminUser->save();
    echo "✅ Tạo admin user thành công!\n";
    echo "Email: {$adminUser->email}\n";
    echo "Username: {$adminUser->username}\n";
    echo "Password: admin123456\n";
    echo "ID: {$adminUser->_id}\n";
    echo "Is Admin: {$adminUser->is_admin}\n";
    echo "Phone: {$adminUser->phone_number}\n";
    echo "Site ID: {$adminUser->site_id}\n";
    echo "Avatar: {$adminUser->avatar}\n";
    
    // Kiểm tra password hashing
    echo "\nPassword hashing info:\n";
    echo "Raw password stored: " . (strlen($adminUser->getOriginal('password')) > 20 ? "Hashed (length: " . strlen($adminUser->getOriginal('password')) . ")" : "Plain text") . "\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi tạo admin user: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
