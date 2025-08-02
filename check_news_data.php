<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\News;
use Illuminate\Support\Str;

echo "🔍 KIỂM TRA DỮ LIỆU NEWS TRONG MONGODB\n";
echo "=====================================\n\n";

try {
    // Get latest 5 news
    $news = News::orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    echo "📊 Tổng số tin: " . News::count() . "\n";
    echo "📰 5 tin mới nhất:\n\n";

    foreach ($news as $index => $item) {
        echo "🔸 Tin " . ($index + 1) . ":\n";
        echo "   📰 Tiêu đề: {$item->name}\n";
        echo "   🆔 ID: {$item->id}\n";
        echo "   👤 User ID: {$item->user_id}\n";
        echo "   📊 Status: {$item->status}\n";
        echo "   👀 Views: {$item->count_view}\n";
        echo "   🏷️  Tags: " . (is_array($item->tags) ? implode(', ', $item->tags) : $item->tags) . "\n";
        echo "   📅 Created: {$item->created_at}\n";
        echo "   📝 Summary: " . Str::limit($item->summary, 80) . "\n";
        echo "\n";
    }

    // Test MongoDB connection
    echo "🔧 KIỂM TRA KẾT NỐI MONGODB:\n";
    $connection = News::getConnection();
    echo "   Database: " . $connection->getDatabaseName() . "\n";
    echo "   Collection: " . (new News)->getTable() . "\n";
    echo "   Connection Type: " . get_class($connection) . "\n\n";

    // Test queryDataWithParams MongoDB method
    echo "🧪 TEST MONGODB QUERY METHOD:\n";
    $testNews = new News();
    
    // Test với tham số tìm kiếm
    $params = [
        's_name' => 'Laravel',
        'limit' => 3
    ];
    
    echo "   Testing search for 'Laravel'...\n";
    // This should trigger the MongoDB-specific query method
    $result = $testNews->queryDataWithParams($params);
    
    if ($result && method_exists($result, 'items')) {
        echo "   ✅ MongoDB query method works!\n";
        echo "   📊 Found: " . $result->total() . " items\n";
        echo "   🔍 Current page items: " . count($result->items()) . "\n";
    } else {
        echo "   ❌ MongoDB query method failed\n";
    }

} catch (\Exception $e) {
    echo "❌ LỖI: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
}

echo "\n🎯 Kiểm tra hoàn tất!\n";
