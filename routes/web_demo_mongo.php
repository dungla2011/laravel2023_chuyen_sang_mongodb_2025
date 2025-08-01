<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestMongo1Controller;

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

Route::get('/', function () {
    return redirect()->route('testmongo1.index');
});

// TestMongo1 Resource Routes
Route::resource('testmongo1', TestMongo1Controller::class);

// API Routes for TestMongo1 (for AJAX requests)
Route::prefix('api/testmongo1')->name('api.testmongo1.')->group(function () {
    Route::get('/', [TestMongo1Controller::class, 'apiIndex'])->name('index');
    Route::post('/', [TestMongo1Controller::class, 'apiStore'])->name('store');
    Route::get('/{id}', [TestMongo1Controller::class, 'apiShow'])->name('show');
    Route::put('/{id}', [TestMongo1Controller::class, 'apiUpdate'])->name('update');
    Route::delete('/{id}', [TestMongo1Controller::class, 'apiDestroy'])->name('destroy');
});

// Additional utility routes
Route::get('/testmongo1/{id}/duplicate', [TestMongo1Controller::class, 'duplicate'])->name('testmongo1.duplicate');
Route::post('/testmongo1/bulk-delete', [TestMongo1Controller::class, 'bulkDelete'])->name('testmongo1.bulk-delete');
Route::get('/testmongo1/export/csv', [TestMongo1Controller::class, 'exportCsv'])->name('testmongo1.export.csv');
Route::get('/testmongo1/export/json', [TestMongo1Controller::class, 'exportJson'])->name('testmongo1.export.json');
