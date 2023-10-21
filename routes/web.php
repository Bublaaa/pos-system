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
});

// Routes for owner
Route::prefix('owner')->middleware(['auth',OwnerMiddleware::class])->group(function () {
    Route::resource('menu', MenuController::class);
    Route::resource('ingredient', IngredientController::class);
    Route::resource('salary', SalaryController::class);
    Route::resource('salary', AttendanceController::class);
    Route::get('/register', [App\Http\Controllers\OwnerController::class, 'register'])->name('register-new-employee');
    Route::get('/salary-payment/{userName}', [App\Http\Controllers\OwnerController::class, 'salaryPayment'])->name('salary-payment');
    Route::post('/print-receipt/{id}', [App\Http\Controllers\OwnerController::class, 'printReceipt'])->name('print-receipt');
    Route::get('/stock-report', [App\Http\Controllers\OwnerController::class, 'stockReport'])->name('stock-report');
    Route::get('/add-stock', [App\Http\Controllers\OwnerController::class, 'addStock'])->name('add-stock');
    Route::get('/add-menu', [App\Http\Controllers\OwnerController::class, 'addMenu'])->name('add-menu');
});


// Routes for headbar
Route::prefix('headbar')->middleware(['auth',HeadbarMiddleware::class])->group(function () {
    Route::get('/add-stock', [App\Http\Controllers\HeadbarController::class, 'addStock'])->name('headbar.add.stock');
});

// Routes for employee
Route::prefix('employee')->middleware(['auth',EmployeeMiddleware::class])->group(function () {
});