<?php
//ute;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BannerTypeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IndexController;

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
    return view('welcome');
});

Route::get('/', [IndexController::class, 'landing_page'])->name('landing_page');
Route::group(['prefix' => 'digital_currency'], function () {
    Route::get('/redis/{id}',[CurrencyController::class, 'test_redis'])->name('test_redis');
    Route::get('/', [CurrencyController::class, 'index'])->name('index_currency');
    Route::get('/test', [CurrencyController::class, 'index'])->name('index_page');
    Route::get('create', [CurrencyController::class, 'create'])->name('create_currency');
    Route::post('store', [CurrencyController::class, 'store'])->name('store_currency');
    Route::DELETE('destroy/{currency}', [CurrencyController::class, 'destroy'])->name('destroy_currency');
    Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('edit_currency');
    Route::get('show/{id}', [CurrencyController::class, 'show'])->name('show_currency');
    Route::put('update/{id}', [CurrencyController::class, 'update'])->name('update_currency');
    Route::get('get_banners/{id}', [CurrencyController::class, 'getBanners'])->name('get_banners');
    Route::get('add_banner/{id}', [CurrencyController::class, 'addBanner'])->name('add_banner');
    Route::get('remove_banner/{currency_id}/{banner_id}', [CurrencyController::class, 'removeBanner'])->name('remove_banner');
    Route::get('attach_banner/{currency_id}', [CurrencyController::class, 'attachBanner'])->name('attach_banner');

});
Route::group(['prefix' => 'banner_type'], function () {
    Route::get('/', [BannerTypeController::class, 'index'])->name('index_banner_type');
    Route::get('create', [BannerTypeController::class, 'create'])->name('create_banner_type');
    Route::post('store', [BannerTypeController::class, 'store'])->name('store_banner_type');
    Route::get('destroy/{id}', [BannerTypeController::class, 'destroy'])->name('destroy_banner_type');
    Route::get('edit/{id}', [BannerTypeController::class, 'edit'])->name('edit_banner_type');
    Route::put('update/{id}', [BannerTypeController::class, 'update'])->name('update_banner_type');
});
Route::group(['prefix' => 'banner'], function () {
    Route::get('/', [BannerController::class, 'index'])->name('index_banner');
    Route::get('create', [BannerController::class, 'create'])->name('create_banner');
    Route::post('store', [BannerController::class, 'store'])->name('store_banner');
    Route::get('destroy/{id}', [BannerController::class, 'destroy'])->name('destroy_banner');
    Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit_banner');
    Route::put('update/{id}', [BannerController::class, 'update'])->name('update_banner');
});



