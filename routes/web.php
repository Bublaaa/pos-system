<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\OwnerMiddleware;
use \App\Http\Middleware\HeadbarMiddleware;
use \App\Http\Middleware\EmployeeMiddleware;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MenuController;


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
    Route::resource('dashboard', MenuController::class);
});

// Routes for owner
Route::prefix('owner')->middleware(['auth',OwnerMiddleware::class])->group(function () {
    Route::get('/register', [App\Http\Controllers\OwnerController::class, 'register'])->name('owner.register');
    Route::get('/add-menu', [App\Http\Controllers\MenuController::class, 'add'])->name('owner.add');
    Route::get('/edit-menu', [App\Http\Controllers\MenuController::class, 'edit'])->name('owner.edit');
    Route::get('/employee-report', [App\Http\Controllers\EmployeeController::class, 'report'])->name('owner.employee.report');
    Route::get('/employee-salary', [App\Http\Controllers\EmployeeController::class, 'salary'])->name('owner.employee.salary');
    Route::get('/stock-report', [App\Http\Controllers\StockController::class, 'report'])->name('owner.stock.report');
    Route::get('/stock-add', [App\Http\Controllers\StockController::class, 'add'])->name('owner.add.stock');
    Route::get('/add-menu/ingredient-add', [App\Http\Controllers\MenuController::class, 'addIngredients'])->name('owner.add.ingredient');
});


// Routes for headbar
Route::prefix('headbar')->middleware(['auth',HeadbarMiddleware::class])->group(function () {
    Route::get('/stock-add', [App\Http\Controllers\StockController::class, 'add'])->name('headbar.add.stock');
    Route::resource('headbar-attendance', AttendanceController::class);
});

// Routes for employee
Route::prefix('employee')->middleware(['auth',EmployeeMiddleware::class])->group(function () {
    Route::resource('employee-attendance', AttendanceController::class);
});