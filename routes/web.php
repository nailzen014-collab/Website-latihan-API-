<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;

Route::get('/', function () {
    return redirect()->route('pendaftaran.index');
});

Route::resource('pendaftaran', PendaftaranController::class)
    ->parameters(['pendaftaran' => 'id'])
    ->names('pendaftaran');

Route::resource('siswa', SiswaController::class)
    ->parameters(['siswa' => 'id'])
    ->names('siswa');

Route::resource('kelas', KelasController::class)
    ->parameters(['kelas' => 'id'])
    ->names('kelas');