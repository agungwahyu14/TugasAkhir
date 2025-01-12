<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\NaskahMasukController;
use App\Http\Controllers\NaskahKeluarController;

Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['verify-token'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/', [AdminController::class, 'store']);
        Route::get('{id}', [AdminController::class, 'show']);
        Route::put('{id}', [AdminController::class, 'update']);
        Route::patch('{id}/deactivate', [AdminController::class, 'deactivate']);
        Route::patch('{id}/activate', [AdminController::class, 'activate']);
        Route::delete('{id}', [AdminController::class, 'destroy']);
    });

    Route::prefix('pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'index']); 
        Route::post('/', [PegawaiController::class, 'store']);
        Route::get('{id}', [PegawaiController::class, 'show']); 
        Route::put('{id}', [PegawaiController::class, 'update']); 
        Route::patch('{id}/deactivate', [PegawaiController::class, 'deactivate']);
        Route::patch('{id}/activate', [PegawaiController::class, 'activate']); 
        Route::delete('{id}', [PegawaiController::class, 'destroy']); 
    });

    Route::prefix('naskah-masuks')->group(function () {
        Route::get('/', [NaskahMasukController::class, 'index'])->name('naskahmasuk.index');
        Route::post('/', [NaskahMasukController::class, 'store'])->name('naskahmasuk.store');
        Route::put('{id}', [NaskahMasukController::class, 'update'])->name('naskahmasuk.update');
        Route::post('/sendWA', [NaskahMasukController::class, 'sendMessage'])->name('naskahmasuk.sendMessage');
        Route::post('/accepet', [NaskahMasukController::class, 'accepet'])->name('naskahmasuk.accepet');
        Route::delete('{id}', [NaskahMasukController::class, 'destroy']);
        Route::get('{id}', [NaskahMasukController::class, 'show'])->name('naskah-masuk.show');
        Route::get('{id}/download', [NaskahMasukController::class, 'downloadFile']); 
    });

    Route::prefix('naskah-keluars')->group(function(){
        Route::get('/', [NaskahKeluarController::class, 'index'])->name('naskahkeluar.index');
        Route::post('/', [NaskahKeluarController::class, 'store'])->name('naskahkeluar.store');
        Route::put('{id}', [NaskahKeluarController::class, 'update'])->name('naskahkeluar.update');
        Route::post('/sendWA', [NaskahKeluarController::class, 'sendMessage'])->name('naskahkeluar.sendMessage');
        Route::post('/accepet', [NaskahKeluarController::class, 'accepet'])->name('naskahkeluar.accepet');
        Route::delete('{id}', [NaskahKeluarController::class, 'destroy']);
        Route::get('{id}', [NaskahKeluarController::class, 'show'])->name('naskahkeluar.show');
        Route::get('{id}/download', [NaskahKeluarController::class, 'downloadFile']); 
    });
    
});


