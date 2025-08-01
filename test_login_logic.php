<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\SiteMng;
use Illuminate\Support\Facades\Hash;

echo "=== TEST LOGIN LOGIC ===\n";

// Thông tin thực tế trong DB
$email = 'admin@abc.com';
$password = 'admin123456';

echo "Thử tìm user với email: $email\n";

// Logic giống trong LoginController
$us = User::where('email', $email)->orWhere('username', $email)->first();

if ($us) {
    echo "✅ Tìm thấy user:\n";
    echo "ID: " . $us->_id . "\n";
    echo "Email: " . $us->email . "\n";
    echo "Username: " . $us->username . "\n";
    echo "Is Admin: " . ($us->is_admin ?? 'null') . "\n";
    
    echo "\n=== TEST PASSWORD ===\n";
    
    $authType = SiteMng::getAuthType();
    $authTypeSha1 = SiteMng::getAuthTypeSha1();
    
    echo "Auth Type: $authType\n";
    echo "Auth Type SHA1: $authTypeSha1\n";
    echo "Stored Password (first 20 chars): " . substr($us->password, 0, 20) . "...\n";
    echo "Password Length: " . strlen($us->password) . "\n";
    
    // Test với logic trong LoginController
    if($authType == 2) {
        $sha = sha1($password . $us->_id);
        $check = ($sha == $us->password);
        echo "SHA1 Check: $check (SHA1: $sha)\n";
    } else {
        $check = Hash::check($password, $us->password);
        echo "Bcrypt Check: $check\n";
    }
    
} else {
    echo "❌ KHÔNG tìm thấy user với email: $email\n";
}

echo "\n=== TEST VỚI USERNAME ===\n";
$username = 'admin';
echo "Thử tìm user với username: $username\n";

$us2 = User::where('email', $username)->orWhere('username', $username)->first();
if ($us2) {
    echo "✅ Tìm thấy user với username:\n";
    echo "Email: " . $us2->email . "\n";
    echo "Username: " . $us2->username . "\n";
} else {
    echo "❌ KHÔNG tìm thấy user với username: $username\n";
}
