<?php

use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasJurusanController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\GuruDashController;
use App\Http\Controllers\Siswa\SiswaDashController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/', [AuthController::class, 'verify'])->name('verify');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' =>'auth:admin'],function () {
    Route::get('/dashboard', [AdminDashController::class, 'index'])->name('a.dashboard');

    Route::get('/periode', [PeriodeController::class, 'index'])->name('a.periode');
    Route::post('/periode/add', [PeriodeController::class, 'store'])->name('a.periode.add');
    Route::post('/periode/aktifkan', [PeriodeController::class, 'aktifkan'])->name('a.periode.aktif');
    Route::delete('/periode/delete/{id}', [PeriodeController::class, 'destroy'])->name('a.periode.delete');

    Route::get('/jurusan', [JurusanController::class, 'index'])->name('a.jurusan');
    Route::post('/jurusan/add', [JurusanController::class, 'store'])->name('a.jurusan.add');
    Route::post('/jurusan/edit/{id}', [JurusanController::class, 'update'])->name('a.jurusan.edit');
    Route::delete('/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('a.jurusan.delete');
    Route::get('/jurusan/export', [JurusanController::class, 'export'])->name('a.jurusan.export');

    Route::get('/mapel', [MapelController::class, 'index'])->name('a.mapel');
    Route::post('/mapel/add', [MapelController::class, 'store'])->name('a.mapel.add');
    Route::post('/mapel/edit/{id}', [MapelController::class, 'update'])->name('a.mapel.edit');
    Route::delete('/mapel/delete/{id}', [MapelController::class, 'destroy'])->name('a.mapel.delete');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('a.siswa');
    Route::post('/siswa/add', [SiswaController::class, 'store'])->name('a.siswa.add');
    Route::post('/siswa/edit/{id}', [SiswaController::class, 'update'])->name('a.siswa.edit');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('a.siswa.delete');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('a.siswa.import');


    Route::get('/kelas_jurusan', [KelasJurusanController::class, 'index'])->name('a.kelas');

    Route::get('/guru', [GuruController::class, 'index'])->name('a.guru');
    Route::post('/guru/add', [GuruController::class, 'store'])->name('a.guru.add');
    Route::post('/guru/edit/{id}', [GuruController::class, 'update'])->name('a.guru.edit');
    Route::delete('/guru/delete/{id}', [GuruController::class, 'destroy'])->name('a.guru.delete');
});

Route::group(['middleware' =>'auth:guru'],function () {
    Route::get('/guru/dashboard', [GuruDashController::class, 'index'])->name('g.dashboard');
});

Route::group(['middleware' =>'auth:siswa'],function () {
    Route::get('/siswa/dashboard', [SiswaDashController::class, 'index'])->name('s.dashboard');
});

