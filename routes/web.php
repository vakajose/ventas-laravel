<?php


use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PageVisitCounter;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\SetTheme;
use App\Http\Middleware\CheckRole;
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

    Route::middleware([CheckRole::class . ':administrador'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('inventories', InventoryController::class);
        Route::resource('sales', SalesController::class);
        Route::resource('payments', PaymentController::class);
        Route::post('/sales/{id}/cancel', [SalesController::class, 'cancel'])->name('sales.cancel');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Para el listado de usuarios
    });

    Route::middleware([CheckRole::class . ':administrador,cliente'])->group(function () {
        Route::resource('reservations', ReservationController::class);
        Route::resource('promotions', PromotionController::class);
        Route::get('user/profile', function () {
            return view('profile.show');
        })->name('profile.show');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings/change-language', [SettingsController::class, 'changeLanguage'])->name('settings.changeLanguage');
        Route::post('settings/change-theme', [SettingsController::class, 'changeTheme'])->name('settings.changeTheme');
    });
});
