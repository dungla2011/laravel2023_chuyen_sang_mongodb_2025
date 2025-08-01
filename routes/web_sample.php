<?php

use App\Components\Route2;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\MediaItemController2;
use App\Http\Controllers\MediaFolderController2;

// Media Items Routes
Route::prefix('media')->name('media.')->group(function () {
    // Items
    Route::resource('items', MediaItemController2::class);
    Route::get('folders/{folder}/items', [MediaItemController2::class, 'getItemsByFolder'])
        ->name('folders.items');

    // Folders (nếu bạn cần thêm Controller cho Folders)
    // Route::resource('folders', MediaFolderController::class);
});



$routeName = 'privacy-01';
$r = Route2::get('/privacy-policy', [
    \App\Http\Controllers\IndexController::class, 'privacyPolicy',
])->name($routeName);

$routeName = 'download_1k';
$r = Route2::get('/apiDownload1k', [
    \App\Http\ControllerApi\DownloadFileControllerApi::class, 'apiDownload1k',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


$routeName = 'buy.vip';
$r = Route2::get('/buy-vip', [
    \App\Http\Controllers\OrderItemController::class, 'buyVip',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


$routeName = 'momoReturn';
$r = Route2::get('/buy-vip/momoReturn', [
    \App\Http\Controllers\OrderItemController::class, 'momoReturn',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;

$routeName = 'momoNotify';
$r = Route2::get('/buy-vip/momoNotify', [
    \App\Http\Controllers\OrderItemController::class, 'momoNotify',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


$routeName = 'buy.vip.post';
$r = Route2::post('/buy-vip', [
    \App\Http\Controllers\OrderItemController::class, 'buyVip',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


$routeName = 'webhook_bk_1k.vip.post';
$r = Route2::post('/webhookBk', [
    \App\Http\Controllers\OrderItemController::class, 'webHookBK',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


$routeName = 'webhook_bk_1k.vip.get';
$r = Route2::get('/webhookBk', [
    \App\Http\Controllers\OrderItemController::class, 'webHookBK',
])->name($routeName)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;


//////////////////////
$routeName = 'task.member.list';
$r = Route2::get('/my-task', [
    \App\Http\Controllers\HrTaskController::class, 'list_task',
])->name($routeName);

Route::view('/test123456', 'admin.demo-api.test3');

Route::view('/admin/hr-cham-cong', 'admin.hr.hr-cham-cong');
Route::view('/admin/hr-cham-cong2', 'admin.hr.hr-cham-cong2');
//Route::view('/admin/hr-salary-month', 'admin.demo-api.hr-salary-user-month');
Route::view('/member/hr-cham-cong', 'admin.hr.hr-cham-cong');

Route::view('/admin/hr-sample-timeframe1', 'admin.hr.demo-timeframe1');

Route::view('/admin/hr-user-expense-month', 'admin.hr.user-expense-month');

