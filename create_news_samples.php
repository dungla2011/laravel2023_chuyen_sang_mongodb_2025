<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\News;
use App\Models\User;

echo "🔥 Tạo 5 tin tức mẫu cho MongoDB...\n\n";

// Get first user or create admin user
$user = User::first();
if (!$user) {
    echo "⚠️  Không tìm thấy user, tạo user admin...\n";
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('123456'),
        'email_verified_at' => now(),
    ]);
    echo "✅ Đã tạo user admin ID: {$user->id}\n\n";
}

// Sample news data
$newsData = [
    [
        'name' => 'Công nghệ AI ChatGPT 4.0 ra mắt với nhiều tính năng mới',
        'summary' => 'OpenAI chính thức công bố phiên bản ChatGPT 4.0 với khả năng xử lý đa phương tiện và tốc độ phản hồi nhanh hơn gấp 10 lần.',
        'content' => '<p>Trong một sự kiện công nghệ quan trọng, OpenAI đã chính thức ra mắt ChatGPT 4.0 - phiên bản AI tiên tiến nhất từng được phát triển.</p>

<h3>Những tính năng nổi bật:</h3>
<ul>
<li>Xử lý hình ảnh, video và âm thanh</li>
<li>Tốc độ phản hồi nhanh hơn 10 lần</li>
<li>Hiểu ngữ cảnh sâu hơn</li>
<li>Hỗ trợ 120 ngôn ngữ</li>
</ul>

<p>Điều này đánh dấu một bước ngoặt quan trọng trong lĩnh vực trí tuệ nhân tạo.</p>',
        'meta_desc' => 'ChatGPT 4.0 ra mắt với khả năng đa phương tiện, tốc độ nhanh hơn và hiểu ngữ cảnh sâu sắc hơn.',
        'status' => 1,
        'publish_status' => 1,
        'count_view' => rand(1500, 5000),
        'orders' => 1,
        'options' => 0,
        'parent_id' => 0,
        'image_list' => '1,2,3', // Giả định có file upload
        'slug' => 'ai-chatgpt-4-ra-mat',
        'tags' => ['AI', 'ChatGPT', 'OpenAI', 'Technology'],
        'category_id' => 1,
    ],
    [
        'name' => 'Laravel 11 chính thức phát hành với nhiều cải tiến đáng chú ý',
        'summary' => 'Framework PHP hàng đầu Laravel vừa ra mắt phiên bản 11 với cải tiến về hiệu suất, bảo mật và trải nghiệm developer.',
        'content' => '<p>Laravel 11 đã chính thức được phát hành với nhiều cải tiến quan trọng dành cho cộng đồng PHP developers.</p>

<h3>Những thay đổi chính:</h3>
<ul>
<li>Cải thiện hiệu suất lên đến 25%</li>
<li>Hệ thống cache mới</li>
<li>Bảo mật được tăng cường</li>
<li>Syntax đơn giản hóa</li>
<li>Hỗ trợ PHP 8.3</li>
</ul>

<p>Đây là bản cập nhật quan trọng mà mọi Laravel developer đều nên quan tâm.</p>',
        'meta_desc' => 'Laravel 11 phát hành với cải tiến hiệu suất 25%, bảo mật tăng cường và syntax đơn giản hóa.',
        'status' => 1,
        'publish_status' => 1,
        'count_view' => rand(800, 2500),
        'orders' => 2,
        'options' => 0,
        'parent_id' => 0,
        'image_list' => '4,5',
        'slug' => 'laravel-11-chinh-thuc-phat-hanh',
        'tags' => ['Laravel', 'PHP', 'Framework', 'Web Development'],
        'category_id' => 2,
    ],
    [
        'name' => 'MongoDB 7.0 hỗ trợ tính năng Time Series mạnh mẽ',
        'summary' => 'Phiên bản MongoDB 7.0 mới nhất tích hợp khả năng xử lý dữ liệu time series hiệu quả, phù hợp cho IoT và analytics.',
        'content' => '<p>MongoDB Corp đã công bố phiên bản 7.0 với tính năng Time Series Collections được cải tiến mạnh mẽ.</p>

<h3>Tính năng Time Series nổi bật:</h3>
<ul>
<li>Nén dữ liệu thông minh</li>
<li>Query performance tối ưu</li>
<li>Automatic data expiration</li>
<li>Real-time aggregation</li>
<li>Horizontal scaling</li>
</ul>

<p>Điều này làm cho MongoDB trở thành lựa chọn tuyệt vời cho các ứng dụng IoT và phân tích dữ liệu.</p>',
        'meta_desc' => 'MongoDB 7.0 tích hợp Time Series Collections mạnh mẽ, tối ưu cho IoT và phân tích dữ liệu real-time.',
        'status' => 1,
        'publish_status' => 1,
        'count_view' => rand(600, 1800),
        'orders' => 3,
        'options' => 0,
        'parent_id' => 0,
        'image_list' => '6,7,8,9',
        'slug' => 'mongodb-7-ho-tro-time-series',
        'tags' => ['MongoDB', 'Database', 'Time Series', 'IoT', 'Analytics'],
        'category_id' => 3,
    ],
    [
        'name' => 'Xu hướng phát triển web 2025: JAMstack và Headless CMS',
        'summary' => 'Các chuyên gia dự đoán JAMstack và Headless CMS sẽ là xu hướng chính trong phát triển web năm 2025.',
        'content' => '<p>Năm 2025 hứa hẹn sẽ là năm bùng nổ của JAMstack và Headless CMS trong cộng đồng web development.</p>

<h3>Tại sao JAMstack hot?</h3>
<ul>
<li>Performance tuyệt vời</li>
<li>Bảo mật cao</li>
<li>Dễ scale</li>
<li>Developer experience tốt</li>
<li>SEO friendly</li>
</ul>

<h3>Headless CMS phổ biến:</h3>
<ul>
<li>Strapi</li>
<li>Contentful</li>
<li>Sanity</li>
<li>Ghost</li>
</ul>

<p>Đây là cơ hội để các developer cập nhật kỹ năng và theo kịp xu hướng mới.</p>',
        'meta_desc' => 'Xu hướng web development 2025: JAMstack và Headless CMS với performance cao, bảo mật tốt và dễ scale.',
        'status' => 1,
        'publish_status' => 1,
        'count_view' => rand(1200, 3500),
        'orders' => 4,
        'options' => 0,
        'parent_id' => 0,
        'image_list' => '10,11',
        'slug' => 'xu-huong-web-development-2025',
        'tags' => ['JAMstack', 'Headless CMS', 'Web Development', 'Trends 2025'],
        'category_id' => 1,
    ],
    [
        'name' => 'Docker và Kubernetes: Cặp đôi hoàn hảo cho DevOps hiện đại',
        'summary' => 'Tìm hiểu cách Docker và Kubernetes kết hợp tạo nên giải pháp containerization và orchestration mạnh mẽ.',
        'content' => '<p>Docker và Kubernetes đã trở thành cặp đôi không thể thiếu trong hệ sinh thái DevOps hiện đại.</p>

<h3>Docker - Containerization:</h3>
<ul>
<li>Đóng gói ứng dụng nhất quán</li>
<li>Portable across environments</li>
<li>Resource efficient</li>
<li>Fast deployment</li>
</ul>

<h3>Kubernetes - Orchestration:</h3>
<ul>
<li>Auto scaling</li>
<li>Load balancing</li>
<li>Self-healing</li>
<li>Rolling updates</li>
<li>Service discovery</li>
</ul>

<p>Việc kết hợp Docker và Kubernetes giúp teams DevOps đạt được reliability, scalability và efficiency cao.</p>',
        'meta_desc' => 'Docker và Kubernetes: Giải pháp containerization và orchestration hoàn hảo cho DevOps hiện đại.',
        'status' => 1,
        'publish_status' => 1,
        'count_view' => rand(900, 2800),
        'orders' => 5,
        'options' => 0,
        'parent_id' => 0,
        'image_list' => '12,13,14',
        'slug' => 'docker-kubernetes-devops-hien-dai',
        'tags' => ['Docker', 'Kubernetes', 'DevOps', 'Containerization', 'Orchestration'],
        'category_id' => 2,
    ],
];

echo "📝 Bắt đầu tạo dữ liệu...\n\n";

$successCount = 0;

foreach ($newsData as $index => $data) {
    try {
        // Add common fields
        $data['user_id'] = $user->id;
        $data['created_at'] = now()->subDays(rand(0, 30));
        $data['updated_at'] = $data['created_at']->addMinutes(rand(1, 60));
        
        // Create news record
        $news = News::create($data);
        
        $successCount++;
        echo "✅ Tin " . ($index + 1) . ": '{$data['name']}' - ID: {$news->id}\n";
        echo "   👀 Views: {$data['count_view']} | 🏷️  Tags: " . implode(', ', $data['tags']) . "\n";
        echo "   📅 Created: {$data['created_at']->format('d/m/Y H:i')}\n\n";

        if($successCount == 1)
            break;
        
    } catch (\Exception $e) {
        echo "❌ Lỗi tạo tin " . ($index + 1) . ": " . $e->getMessage() . "\n\n";
    }
}

echo "🎉 HOÀN THÀNH!\n";
echo "📊 Tổng kết:\n";
echo "   ✅ Đã tạo thành công: {$successCount}/5 tin\n";
echo "   👤 User ID: {$user->id} ({$user->name})\n";
echo "   💾 Database: MongoDB\n\n";

// Show sample query
echo "🔍 Test query MongoDB:\n";
try {
    $totalNews = News::count();
    $latestNews = News::orderBy('created_at', 'desc')->first();
    
    echo "   📈 Tổng số tin: {$totalNews}\n";
    if ($latestNews) {
        echo "   📰 Tin mới nhất: '{$latestNews->name}'\n";
        echo "   👀 Views: {$latestNews->count_view}\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Lỗi query: " . $e->getMessage() . "\n";
}

echo "\n🎯 Script hoàn tất!\n";
