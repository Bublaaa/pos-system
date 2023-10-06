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


// Redirect to login
Route::get('/', function () {
    return redirect('/');
});

Auth::routes();

// Redirect based on user position
Route::middleware(['auth'])->group(function () {
   Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('login');
});

// Routes for owner
Route::prefix('owner')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.dashboard');
});

// Routes for headbar
Route::prefix('headbar')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HeadbarController::class, 'index'])->name('headbar.dashboard');
});

// Routes for employee
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('employee.dashboard');
});