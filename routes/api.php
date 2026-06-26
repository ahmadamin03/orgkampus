<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProkerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SuratController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);

        Route::apiResource('/members', MemberController::class);
        Route::apiResource('/prokers', ProkerController::class);
        Route::apiResource('/events', EventController::class);
        Route::apiResource('/surats', SuratController::class);
        Route::apiResource('/keuangans', KeuanganController::class);
        Route::apiResource('/tugas', TugasController::class);
    });
});
