<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KeuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Anggota
    Route::resource('members', MemberController::class);

    // Proker & Tugas
    Route::resource('prokers', ProkerController::class);
    Route::post('prokers/{proker}/tasks', [ProkerController::class, 'storeTask'])->name('prokers.tasks.store');
    Route::put('tasks/{task}/status', [ProkerController::class, 'updateTaskStatus'])->name('tasks.status.update');
    Route::delete('tasks/{task}', [ProkerController::class, 'destroyTask'])->name('tasks.destroy');

    // Event & Panitia
    Route::resource('events', EventController::class);
    Route::post('events/{event}/committees', [EventController::class, 'storeCommittee'])->name('events.committees.store');
    Route::delete('committees/{committee}', [EventController::class, 'destroyCommittee'])->name('committees.destroy');

    // Surat
    Route::resource('surats', SuratController::class);

    // Keuangan
    Route::resource('keuangans', KeuanganController::class);
});
