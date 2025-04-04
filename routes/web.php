<?php

use App\Http\Controllers\Admin\PeriodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::get('/periode', [PeriodeController::class, 'index'])->name('a.periode');
Route::post('/periode/add', [PeriodeController::class, 'store'])->name('a.periode.add');
Route::post('/periode/aktifkan', [PeriodeController::class, 'aktifkan'])->name('a.periode.aktif');
Route::delete('/periode/delete/{id}', [PeriodeController::class, 'destroy'])->name('a.periode.delete');