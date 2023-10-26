<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\OwnerMiddleware;
use \App\Http\Middleware\HeadbarMiddleware;
use \App\Http\Middleware\EmployeeMiddleware;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShiftController;

Auth::routes();

// Redirect based on user position
Route::middleware(['auth'])->group(function () {
   Route::get('/', function () {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login ');
        } else {
            return redirect('/dashboard');
        }
    });
});
Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', TransactionController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('stock', StockController::class);
    Route::resource('user', UserController::class);
    Route::resource('shift', ShiftController::class);
});

// Routes for owner
Route::prefix('owner')->middleware(['auth',OwnerMiddleware::class])->group(function () {
    Route::resource('menu', MenuController::class);
    Route::resource('ingredient', IngredientController::class);
    Route::resource('salary', SalaryController::class);
    Route::get('/register', [App\Http\Controllers\OwnerController::class, 'register'])->name('register-new-employee');
    Route::get('/salary-payment/{userName}', [App\Http\Controllers\OwnerController::class, 'salaryPayment'])->name('salary-payment');
    Route::post('/print-receipt/{id}', [App\Http\Controllers\OwnerController::class, 'printReceipt'])->name('print-receipt');
});


// Routes for headbar
Route::prefix('headbar')->middleware(['auth',HeadbarMiddleware::class])->group(function () {
});

// Routes for employee
Route::prefix('employee')->middleware(['auth'])->group(function () {
});