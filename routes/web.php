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
Route::prefix('owner')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/register', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.register');
});


// Routes for headbar
Route::prefix('headbar')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HeadbarController::class, 'index'])->name('headbar.dashboard');
});

// Routes for employee
Route::prefix('employee')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.dashboard');
});