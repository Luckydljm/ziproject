<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RekapMomentController;
use App\Http\Controllers\ReminderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal langsung ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==== AUTH ====
// Form login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Form register
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
// Proses register
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==== HANYA BISA DIAKSES SETELAH LOGIN ====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/moment/create', [RekapMomentController::class, 'create'])->name('moment.create');
    Route::post('/moment', [RekapMomentController::class, 'store'])->name('moment.store');
    Route::get('/histori', [RekapMomentController::class, 'histori'])->name('moment.histori');

    Route::get('/rekap-moment/export', [RekapMomentController::class, 'export'])->name('rekapmoment.export');

    Route::get('/data-pengguna', [UserController::class, 'index'])->name('users.index');
    Route::get('/data-pengguna/{user}', [UserController::class, 'showHistori'])->name('users.histori');
    Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
});