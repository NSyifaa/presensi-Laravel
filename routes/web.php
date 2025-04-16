<?php

use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::get('/periode', [PeriodeController::class, 'index'])->name('a.periode');
Route::post('/periode/add', [PeriodeController::class, 'store'])->name('a.periode.add');
Route::post('/periode/aktifkan', [PeriodeController::class, 'aktifkan'])->name('a.periode.aktif');
Route::delete('/periode/delete/{id}', [PeriodeController::class, 'destroy'])->name('a.periode.delete');

Route::get('/jurusan', [JurusanController::class, 'index'])->name('a.jurusan');
Route::post('/jurusan/add', [JurusanController::class, 'store'])->name('a.jurusan.add');
Route::post('/jurusan/edit/{id}', [JurusanController::class, 'update'])->name('a.jurusan.edit');
Route::delete('/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('a.jurusan.delete');

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('a.mahasiswa');