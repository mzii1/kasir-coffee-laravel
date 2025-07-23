<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Livewire\CheckOutPage;
use App\Livewire\TransaksiPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

// Rute untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('users', UserController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
});

// Rute untuk kasir dan admin
Route::middleware(['auth', 'role:kasir,admin'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});

// Rute untuk unauthorized access
Route::get('/unauthorized', function () {
    return response()->view('unauthorized', [], 403);
})->name('unauthorized');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    #Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    #Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

    Route::resource('transaksi', TransaksiController::class);

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    Route::get('laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
    Route::get('laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::post('/keranjang/tambah', [TransaksiController::class, 'tambahKeranjang'])->name('keranjang.tambah');

    Route::delete('/keranjang/hapus/{id}', [TransaksiController::class, 'hapusKeranjang'])->name('keranjang.hapus');

    Route::post('/keranjang/update/{id}', [TransaksiController::class, 'updateKeranjang'])->name('keranjang.update');

    Route::get('/transaksi', TransaksiPage::class)->name('transaksi.index');


    Route::get('/struk/{id}', [TransaksiController::class, 'cetakStruk'])->name('struk.cetak');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', CheckOutPage::class)->name('checkout');
});

Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

require __DIR__.'/auth.php';

