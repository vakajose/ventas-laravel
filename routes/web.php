<?php


use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\PageVisitCounter;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\SetTheme;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    PageVisitCounter::class,
    SetLocale::class,
    SetTheme::class,
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('reservations', ReservationController::class);


    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/change-language', [SettingsController::class, 'changeLanguage'])->name('settings.changeLanguage');
    Route::post('settings/change-theme', [SettingsController::class, 'changeTheme'])->name('settings.changeTheme');
});

