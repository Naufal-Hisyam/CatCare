<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


Route::get('/profil', function () {
    return view('profile.profile', [
        'user' => Auth::user(),
    ]);
})->name('admin.profile.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware(['auth'])->group(function () {
    
    Route::resource('cats', CatController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/profil', function () {
            return view('profile.profile', [
                'user' => Auth::user(),
            ]);
        })->name('admin.profile.show');
    });


    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/pelanggan/dashboard', [DashboardController::class, 'index'])->name('pelanggan.dashboard');

        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.show');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});