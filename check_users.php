<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== KIỂM TRA USER TRONG DATABASE ===\n";

$users = User::all();
echo "Tổng số users: " . $users->count() . "\n\n";

foreach($users as $user) {
    echo "ID: " . $user->_id . "\n";
    echo "Email: " . ($user->email ?? 'null') . "\n";
    echo "Username: " . ($user->username ?? 'null') . "\n";
    echo "Is Admin: " . ($user->is_admin ?? 'null') . "\n";
    echo "Created: " . ($user->created_at ?? 'null') . "\n";
    echo "---\n";
}

echo "\n=== TÌM USER VỚI EMAIL admin@example.com ===\n";
$adminUser = User::where('email', 'admin@example.com')->first();
if ($adminUser) {
    echo "✅ Tìm thấy user:\n";
    echo "ID: " . $adminUser->_id . "\n";
    echo "Email: " . $adminUser->email . "\n";
    echo "Username: " . $adminUser->username . "\n";
} else {
    echo "❌ KHÔNG tìm thấy user với email admin@example.com\n";
}

echo "\n=== TÌM USER VỚI USERNAME admin ===\n";
$adminUserByUsername = User::where('username', 'admin')->first();
if ($adminUserByUsername) {
    echo "✅ Tìm thấy user:\n";
    echo "ID: " . $adminUserByUsername->_id . "\n";
    echo "Email: " . $adminUserByUsername->email . "\n";
    echo "Username: " . $adminUserByUsername->username . "\n";
} else {
    echo "❌ KHÔNG tìm thấy user với username admin\n";
}

echo "\n=== KIỂM TRA BẢNG/COLLECTION NAME ===\n";
$userModel = new User();
echo "Table/Collection name: " . $userModel->getTable() . "\n";
echo "Connection: " . $userModel->getConnectionName() . "\n";
