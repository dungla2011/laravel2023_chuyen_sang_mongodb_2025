<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\SiteMng;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "=== KIỂM TRA DATABASE CONNECTION ===\n";

// Kiểm tra config database
$mongoConfig = Config::get('database.connections.mongodb');
echo "MongoDB Config:\n";
echo "- Host: " . ($mongoConfig['host'] ?? 'not set') . "\n";
echo "- Port: " . ($mongoConfig['port'] ?? 'not set') . "\n";
echo "- Database: " . ($mongoConfig['database'] ?? 'not set') . "\n";
echo "- Username: " . ($mongoConfig['username'] ?? 'not set') . "\n";

echo "\n=== KIỂM TRA SITEMNG DB NAME ===\n";
$siteDbName = SiteMng::getDbName();
echo "SiteMng::getDbName(): " . ($siteDbName ?? 'null') . "\n";

echo "\n=== KIỂM TRA DOMAIN ===\n";
$domain = \LadLib\Common\UrlHelper1::getDomainHostName();
echo "Current domain: " . $domain . "\n";

// Kiểm tra global variable
if (isset($GLOBALS['mMapDomainDb'])) {
    echo "mMapDomainDb exists\n";
    echo "Domain mapping: \n";
    print_r($GLOBALS['mMapDomainDb']);
} else {
    echo "mMapDomainDb NOT exists\n";
}

echo "\n=== KIỂM TRA DB CONNECTION THỰC TẾ ===\n";
try {
    $dbName = DB::connection('mongodb')->getMongoDB()->getDatabaseName();
    echo "Actual MongoDB database name: " . $dbName . "\n";
} catch (Exception $e) {
    echo "Error getting DB name: " . $e->getMessage() . "\n";
}

echo "\n=== KIỂM TRA USER MODEL CONNECTION ===\n";
$userModel = new User();
echo "User model connection: " . $userModel->getConnectionName() . "\n";
echo "User model table: " . $userModel->getTable() . "\n";

echo "\n=== TÌM USER BẰNG NHIỀU CÁCH ===\n";

// Cách 1: Trực tiếp
echo "1. Tìm trực tiếp:\n";
$user1 = User::where('email', 'admin@abc.com')->first();
echo $user1 ? "✅ Found: " . $user1->email . " (ID: " . $user1->_id . ")" : "❌ Not found";
echo "\n";

// Cách 2: Raw query
echo "2. Raw MongoDB query:\n";
try {
    $collection = DB::connection('mongodb')->collection('users');
    $rawUser = $collection->where('email', 'admin@abc.com')->first();
    echo $rawUser ? "✅ Found: " . $rawUser['email'] . " (ID: " . $rawUser['_id'] . ")" : "❌ Not found";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "\n";

// Cách 3: All users
echo "3. Tất cả users:\n";
$allUsers = User::all();
echo "Total users: " . $allUsers->count() . "\n";
foreach($allUsers as $u) {
    echo "- Email: " . $u->email . ", Username: " . $u->username . "\n";
}

echo "\n=== KIỂM TRA COLLECTIONS TRONG DB ===\n";
try {
    $db = DB::connection('mongodb')->getMongoDB();
    $collections = $db->listCollections();
    echo "Collections in database:\n";
    foreach ($collections as $collection) {
        echo "- " . $collection->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Error listing collections: " . $e->getMessage() . "\n";
}
