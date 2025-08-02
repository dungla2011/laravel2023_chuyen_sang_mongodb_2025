<?php 



require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\DB;


// $status = News::insert([
//     'name' => '1111',
// ]);

// dump($status);

// return;
// $news = new News;
// $news->name = "ABC";
// // $news->parent_id = $pid;
// $news->save();

// $id = (string) $news->_id;

// echo "Inserted News ID: $id\n";

// return;

use MongoDB\Client;

// Kết nối đến MongoDB
$client = new Client("mongodb://127.0.0.1:27017");

// Chọn database và collection
$collection = $client->glx2023_for_testing->users;

// Thêm document
$insertResult = $collection->insertOne([
    'name' => 'Alice',
    'email' => 'alice@example.com'
]);

// Lấy ID vừa insert
echo "Inserted ID: " . $insertResult->getInsertedId() . "\n";

echo "\n=== So sánh với Laravel Eloquent ===\n";

// Test với Laravel Eloquent
$user = User::create([
    'name' => 'Bob Laravel',
    'email' => 'bob@example.com'
]);

echo "Laravel Eloquent result:\n";
echo "user->id: " . ($user->id ?? 'null') . "\n";
echo "user->_id: " . (isset($user->_id) ? $user->_id : 'null') . "\n";
echo "user attributes: " . json_encode($user->getAttributes()) . "\n";

// Thử refresh
try {
    $user->refresh();
    echo "After refresh - user->id: " . ($user->id ?? 'null') . "\n";
} catch (\Exception $e) {
    echo "Refresh failed: " . $e->getMessage() . "\n";
}

// Thử query lại
$foundUser = User::where('email', 'bob@example.com')->first();
if ($foundUser) {
    echo "Found user ID: " . $foundUser->id . "\n";
    echo "Found user _id: " . $foundUser->_id . "\n";
}

echo "\n=== Test tạo ObjectId trước ===\n";

// Tạo ObjectId trước
$objectId = new \MongoDB\BSON\ObjectId();
echo "Generated ObjectId: " . $objectId . "\n";
echo "ObjectId type: " . gettype($objectId) . "\n";
echo "ObjectId class: " . get_class($objectId) . "\n";

// Thử tạo User với ObjectId định sẵn
$userWithId = User::create([
    '_id' => $objectId,
    'name' => 'Charlie Pre-ID',
    'email' => 'charlie@example.com'
]);

echo "User created with pre-defined ObjectId:\n";
echo "userWithId->id: " . ($userWithId->id ?? 'null') . "\n";
echo "userWithId->_id: " . (isset($userWithId->_id) ? $userWithId->_id : 'null') . "\n";
echo "Pre-defined ObjectId matches: " . ($userWithId->_id == $objectId ? 'Yes' : 'No') . "\n";

// Kiểm tra trong database
$foundUserWithId = User::find((string)$objectId);
if ($foundUserWithId) {
    echo "Found user in DB with predefined ID: Yes\n";
    echo "Found user name: " . $foundUserWithId->name . "\n";
    echo "Found user _id: " . $foundUserWithId->_id . "\n";
} else {
    echo "Found user in DB with predefined ID: No\n";
}

// Kiểm tra bằng raw query
$rawQuery = User::where('_id', $objectId)->first();
if ($rawQuery) {
    echo "Raw query found: Yes\n";
    echo "Raw query _id: " . $rawQuery->_id . "\n";
} else {
    echo "Raw query found: No\n";
}

// Kiểm tra attributes
echo "userWithId attributes: " . json_encode($userWithId->getAttributes()) . "\n";

// Test tính duy nhất - thử tạo ObjectId trùng
echo "\n=== Test tính duy nhất ===\n";
try {
    $duplicateUser = User::create([
        '_id' => $objectId, // Cùng ObjectId
        'name' => 'Duplicate User',
        'email' => 'duplicate@example.com'
    ]);
    echo "Duplicate creation: SUCCESS (This shouldn't happen!)\n";
} catch (\Exception $e) {
    echo "Duplicate creation: FAILED (Good!)\n";
    echo "Error: " . $e->getMessage() . "\n";
}

// Test nhiều ObjectId khác nhau
echo "\n=== Test nhiều ObjectId khác nhau ===\n";
$ids = [];
for ($i = 1; $i <= 5; $i++) {
    $newId = new \MongoDB\BSON\ObjectId();
    $ids[] = (string)$newId;
    
    $testUser = User::create([
        '_id' => $newId,
        'name' => "Test User $i",
        'email' => "test$i@example.com"
    ]);
    
    echo "User $i - ID: " . $testUser->_id . "\n";
}

echo "All IDs unique: " . (count($ids) === count(array_unique($ids)) ? 'Yes' : 'No') . "\n";
echo "IDs generated: " . implode(', ', $ids) . "\n";

return;

$ret = MenuTree::create([
    'name'=> ' Test Node',
    
]);

dump($ret->toArray());
