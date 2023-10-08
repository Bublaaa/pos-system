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
    Route::get('/stock-report', [App\Http\Controllers\ReportController::class, 'stock'])->name('owner.stock');
    Route::get('/absent-report', [App\Http\Controllers\ReportController::class, 'absent'])->name('owner.absent');
    Route::get('/add-menu', [App\Http\Controllers\MenuController::class, 'add'])->name('owner.add');
    Route::get('/edit-menu', [App\Http\Controllers\MenuController::class, 'edit'])->name('owner.edit');
});


// Routes for headbar
Route::prefix('headbar')->middleware(['auth',HeadbarMiddleware::class])->group(function () {
    Route::get('/', [App\Http\Controllers\HeadbarController::class, 'index'])->name('headbar.dashboard');
});

// Routes for employee
Route::prefix('employee')->middleware(['auth',EmployeeMiddleware::class])->group(function () {
    Route::get('/', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.dashboard');
});