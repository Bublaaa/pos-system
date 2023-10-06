<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/');
});

Auth::routes();

// Route::prefix('/')->middleware('auth')->group(function () {
//     Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//     Route::get('/register', [App\Http\Controllers\HomeController::class, 'create'])->name('register');
    // Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    // Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    // Route::resource('products', ProductController::class);
    // Route::resource('customers', CustomerController::class);
    // Route::resource('orders', OrderController::class);

    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    // Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    // Route::delete('/cart/delete', [CartController::class, 'delete']);
    // Route::delete('/cart/empty', [CartController::class, 'empty']);
// });



// Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::middleware(['auth'])->group(function () {
   Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
   Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('login');
//    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');
});