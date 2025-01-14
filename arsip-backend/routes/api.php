<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\PathArsipController;
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
    

    Route::prefix('disposisis')->group(function () {
        Route::get('/', [DisposisiController::class, 'index'])->name('disposisi.index'); // Menampilkan semua data disposisi
        Route::post('/', [DisposisiController::class, 'store'])->name('disposisi.store'); // Menyimpan data disposisi baru
        Route::get('{id}', [DisposisiController::class, 'show'])->name('disposisi.show'); // Menampilkan detail disposisi berdasarkan ID
        Route::put('{id}', [DisposisiController::class, 'update'])->name('disposisi.update'); // Memperbarui data disposisi berdasarkan ID
        Route::delete('{id}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy'); // Menghapus data disposisi berdasarkan ID
    });

    Route::prefix('path-arsips')->group(function () {

        // Menampilkan semua arsip
        Route::get('/', [PathArsipController::class, 'index'])->name('path-arsips.index');
        
        // Menampilkan arsip berdasarkan ID
        Route::get('{id}', [PathArsipController::class, 'show'])->name('path-arsips.show');
        
        // Membuat arsip baru
        Route::post('/store', [PathArsipController::class, 'store'])->name('path-arsips.store');
        
        // Mengupdate arsip berdasarkan ID
        Route::put('{id}', [PathArsipController::class, 'update'])->name('path-arsips.update');
        
        // Menghapus arsip berdasarkan ID
        Route::delete('{id}', [PathArsipController::class, 'destroy'])->name('path-arsips.destroy');
    });
    
    // Routes untuk Folder
    Route::prefix('folders')->group(function () {

        // Menampilkan semua folder dan subfolder (folder root saja)
        Route::get('/', [FolderController::class, 'index']);
        
        // Menampilkan isi folder tertentu (folder dan arsip/file di dalamnya)
        Route::get('{id}', [FolderController::class, 'show']);
        
        // Membuat folder baru dan mengaitkannya dengan arsip
        Route::post('/', [FolderController::class, 'store']);
        
        // Mengupload file ke folder tertentu
        Route::post('{folderId}/upload', [FolderController::class, 'uploadFile']);
        
        // Menghapus folder berdasarkan ID
        Route::delete('{id}', [FolderController::class, 'destroy']);
        
        // Menghapus file berdasarkan ID file (arsip) dari folder
        Route::delete('{folderId}/file/{fileId}', [FolderController::class, 'destroyFile']);
        
        // Menghapus folder dan file terkait (tidak hanya soft delete)
        Route::delete('{id}/force', [FolderController::class, 'forceDelete']);
         // Menghubungkan Folder dengan PathArsip
        Route::post('{folderId}/attach-arsip/{pathArsipId}', [FolderController::class, 'attachArsipToFolder']);

        // Menghapus hubungan Folder dengan PathArsip
        Route::post('{folderId}/detach-arsip/{pathArsipId}', [FolderController::class, 'detachArsipFromFolder']);
    });

});


