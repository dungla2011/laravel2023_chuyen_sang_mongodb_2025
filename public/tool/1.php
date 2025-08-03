<?php 



require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MenuTree;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\DB;

$ret = MenuTree::withTrashed()->get(); // Lấy tất cả records bao gồm đã xóa
// $ret = MenuTree::all(); // Chỉ lấy records chưa bị xóa (39 records)
// $ret = MenuTree::onlyTrashed()->get(); // Chỉ lấy records đã bị xóa (229 records)
// $ret = MenuTree::where('deleted_at', null)->get();

// $m1 = MenuTree::where('parent_id',fx_to_mongo_object_id('688d7d5e397c13fd880fce49'))->get();

// echo "<pre>";
// print_r($m1->toArray());
// echo "</pre>";


echo "<pre> . " . count($ret) . " items\n ";
print_r($ret->toArray());
echo "</pre>";