<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\PensiunController;

Route::post('/get-pensiun-data', [PensiunController::class, 'getPensiunData'])->name('pensiun.getData');

Route::post('/get-cuti-data', [CutiController::class, 'getCutiData'])->name('cuti.getData');

Route::get('/', function () {
    return view('index');
});
