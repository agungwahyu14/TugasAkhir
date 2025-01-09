<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;

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
 

