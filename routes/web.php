<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\OwnerMiddleware;
use \App\Http\Middleware\HeadbarMiddleware;
use \App\Http\Middleware\EmployeeMiddleware;

Auth::routes();

// Redirect based on user position
Route::middleware(['auth'])->group(function () {
   Route::get('/', function () {
        $user = auth()->user();
        if ($user->position === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif ($user->position === 'headbar') {
            return redirect()->route('headbar.dashboard'); // Adjust the route name for headbar users
        } elseif ($user->position === 'employee') {
            return redirect()->route('employee.dashboard'); // Adjust the route name for headbar users
        }
        // Default redirection if position is not recognized
        return redirect('/login ');
    });
});

// Routes for owner
Route::prefix('owner')->middleware(['auth',OwnerMiddleware::class])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/register', [App\Http\Controllers\OwnerController::class, 'register'])->name('owner.register');
    Route::get('/add-menu', [App\Http\Controllers\MenuController::class, 'add'])->name('owner.add');
    Route::get('/edit-menu', [App\Http\Controllers\MenuController::class, 'edit'])->name('owner.edit');
    Route::get('/employee-report', [App\Http\Controllers\EmployeeController::class, 'report'])->name('owner.employee.report');
    Route::get('/employee-salary', [App\Http\Controllers\EmployeeController::class, 'salary'])->name('owner.employee.salary');
    Route::get('/stock-report', [App\Http\Controllers\StockController::class, 'report'])->name('owner.stock.report');
    Route::get('/stock-add', [App\Http\Controllers\StockController::class, 'add'])->name('owner.add.stock');
});


// Routes for headbar
Route::prefix('headbar')->middleware(['auth',HeadbarMiddleware::class])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HeadbarController::class, 'index'])->name('headbar.dashboard');
    Route::get('/attendance', [App\Http\Controllers\EmployeeController::class, 'attendance'])->name('headbar.attendance');
    Route::get('/stock-add', [App\Http\Controllers\StockController::class, 'add'])->name('headbar.add.stock');
});

// Routes for employee
Route::prefix('employee')->middleware(['auth',EmployeeMiddleware::class])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.dashboard');
    Route::get('/attendance', [App\Http\Controllers\EmployeeController::class, 'attendance'])->name('employee.attendance');

});