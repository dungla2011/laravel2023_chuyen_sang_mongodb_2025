<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use MongoDB\BSON\ObjectId;

echo "=== Test ObjectId với các cách khác nhau ===\n";

// Cách 1: Sử dụng 'id' thay vì '_id'
echo "\n1. Test với field 'id':\n";
$objectId1 = new ObjectId();
echo "Generated ObjectId: " . $objectId1 . "\n";

$user1 = User::create([
    'id' => $objectId1,
    'name' => 'Test ID Field',
    'email' => 'testid@example.com'
]);

echo "user1->id: " . ($user1->id ?? 'null') . "\n";
echo "user1->_id: " . (isset($user1->_id) ? $user1->_id : 'null') . "\n";

// Kiểm tra trong DB
$found1 = User::find((string)$objectId1);
echo "Found in DB: " . ($found1 ? 'Yes' : 'No') . "\n";

// Cách 2: Sử dụng save() thay vì create()
echo "\n2. Test với save():\n";
$objectId2 = new ObjectId();
echo "Generated ObjectId: " . $objectId2 . "\n";

$user2 = new User();
$user2->_id = $objectId2;
$user2->name = 'Test Save Method';
$user2->email = 'testsave@example.com';
$saved = $user2->save();

echo "Save result: " . ($saved ? 'Success' : 'Failed') . "\n";
echo "user2->id: " . ($user2->id ?? 'null') . "\n";
echo "user2->_id: " . (isset($user2->_id) ? $user2->_id : 'null') . "\n";

// Kiểm tra trong DB
$found2 = User::find((string)$objectId2);
echo "Found in DB: " . ($found2 ? 'Yes' : 'No') . "\n";

// Cách 3: Sử dụng setAttribute
echo "\n3. Test với setAttribute:\n";
$objectId3 = new ObjectId();
echo "Generated ObjectId: " . $objectId3 . "\n";

$user3 = new User();
$user3->setAttribute('_id', $objectId3);
$user3->name = 'Test setAttribute';
$user3->email = 'testsetattr@example.com';
$saved3 = $user3->save();

echo "Save result: " . ($saved3 ? 'Success' : 'Failed') . "\n";
echo "user3->id: " . ($user3->id ?? 'null') . "\n";
echo "user3->_id: " . (isset($user3->_id) ? $user3->_id : 'null') . "\n";

// Kiểm tra trong DB
$found3 = User::find((string)$objectId3);
echo "Found in DB: " . ($found3 ? 'Yes' : 'No') . "\n";

// Cách 4: Raw MongoDB query
echo "\n4. Test Raw MongoDB:\n";
$objectId4 = new ObjectId();
echo "Generated ObjectId: " . $objectId4 . "\n";

$collection = app('db')->connection('mongodb')->getCollection('users');
$result = $collection->insertOne([
    '_id' => $objectId4,
    'name' => 'Test Raw Insert',
    'email' => 'testraw@example.com',
    'created_at' => new \MongoDB\BSON\UTCDateTime(),
    'updated_at' => new \MongoDB\BSON\UTCDateTime()
]);

echo "Raw insert result: " . ($result->getInsertedId() == $objectId4 ? 'Success' : 'Failed') . "\n";
echo "Inserted ID: " . $result->getInsertedId() . "\n";

// Kiểm tra bằng Eloquent
$found4 = User::find((string)$objectId4);
echo "Found via Eloquent: " . ($found4 ? 'Yes' : 'No') . "\n";
if ($found4) {
    echo "Found name: " . $found4->name . "\n";
    echo "Found _id: " . $found4->_id . "\n";
}

echo "\n=== Kết luận ===\n";
echo "Các ObjectId đã tạo:\n";
echo "1. " . $objectId1 . "\n";
echo "2. " . $objectId2 . "\n"; 
echo "3. " . $objectId3 . "\n";
echo "4. " . $objectId4 . "\n";

// Tính unique
$allIds = [(string)$objectId1, (string)$objectId2, (string)$objectId3, (string)$objectId4];
echo "All IDs unique: " . (count($allIds) === count(array_unique($allIds)) ? 'Yes' : 'No') . "\n";
