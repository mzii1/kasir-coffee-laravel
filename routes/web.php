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
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); 

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

    Route::get('/tailwind-demo', function () {
        return view('tailwind-demo');
    });

    Route::post('/keranjang/tambah', [TransaksiController::class, 'tambahKeranjang'])->name('keranjang.tambah');

    Route::delete('/keranjang/hapus/{id}', [TransaksiController::class, 'hapusKeranjang'])->name('keranjang.hapus');

    Route::post('/keranjang/update/{id}', [TransaksiController::class, 'updateKeranjang'])->name('keranjang.update');

    Route::get('/transaksi', TransaksiPage::class)->name('transaksi.index');

    Route::get('/checkout', CheckOutPage::class)->name('checkout');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

require __DIR__.'/auth.php';

