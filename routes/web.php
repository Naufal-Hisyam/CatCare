
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

// Halaman awal
Route::get('/', function () {
    return redirect()->route('login');
});

// Daftar layanan penitipan
Route::get('/layanan', [LayananController::class, 'index'])
    ->name('layanan.index');

// Detail layanan penitipan
Route::get('/layanan/{layanan}', [LayananController::class, 'show'])
    ->name('layanan.show');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Tambah layanan
    Route::get('/layanan/tambah', [LayananController::class, 'create'])
        ->name('layanan.create');

    Route::post('/layanan', [LayananController::class, 'store'])
        ->name('layanan.store');

    // Edit layanan
    Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])
        ->name('layanan.edit');

    // Simpan perubahan layanan
    Route::put('/layanan/{layanan}', [LayananController::class, 'update'])
        ->name('layanan.update');

    // Hapus layanan
    Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy'])
        ->name('layanan.destroy');
});

// Login dan register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Halaman yang membutuhkan login
Route::middleware('auth')->group(function () {

    // Dashboard dan logout
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur data kucing dari Naufal
    Route::resource('cats', CatController::class);

    // Halaman admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class);

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/profil', function () {
            return view('profile.profile', [
                'user' => Auth::user(),
            ]);
        })->name('profile.show');
    });

    // Pengalihan halaman customers
    Route::middleware('role:admin')->group(function () {
        Route::get('/customers', function () {
            return redirect()->route('admin.customers.index');
        });
    });

    // Halaman pelanggan
    Route::middleware('role:pelanggan')->group(function () {

        Route::get('/pelanggan/dashboard', [DashboardController::class, 'index'])
            ->name('pelanggan.dashboard');

        Route::get('/profil', [ProfileController::class, 'edit'])
            ->name('profile.show');

        Route::put('/profil', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password.update');
    });
});

// Pengajuan penitipan khusus pelanggan
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/penitipan/ajukan', [PenitipanController::class, 'create'])
        ->name('penitipan.create');

    Route::post('/penitipan/ajukan', [PenitipanController::class, 'store'])
        ->name('penitipan.store');
});

// Halaman tidak ditemukan
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});