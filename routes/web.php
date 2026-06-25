<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Members
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{user}', [MemberController::class, 'show'])->name('members.show');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::put('/members/{user}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{user}', [MemberController::class, 'destroy'])->name('members.destroy');

    // Prokers
    Route::get('/prokers', [ProkerController::class, 'index'])->name('prokers.index');
    Route::get('/prokers/{proker}', [ProkerController::class, 'show'])->name('prokers.show');
    Route::post('/prokers', [ProkerController::class, 'store'])->name('prokers.store');
    Route::put('/prokers/{proker}', [ProkerController::class, 'update'])->name('prokers.update');
    Route::delete('/prokers/{proker}', [ProkerController::class, 'destroy'])->name('prokers.destroy');

    // Tasks
    Route::post('/prokers/{proker}/tasks', [TaskController::class, 'store'])->name('prokers.tasks.store');
    Route::put('/tasks/{tugas}/status', [TaskController::class, 'updateStatus'])->name('tasks.status.update');
    Route::delete('/tasks/{tugas}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Surats
    Route::get('/surats', [SuratController::class, 'index'])->name('surats.index');
    Route::post('/surats', [SuratController::class, 'store'])->name('surats.store');
    Route::put('/surats/{surat}', [SuratController::class, 'update'])->name('surats.update');
    Route::delete('/surats/{surat}', [SuratController::class, 'destroy'])->name('surats.destroy');

    // Keuangans
    Route::get('/keuangans', [KeuanganController::class, 'index'])->name('keuangans.index');
    Route::post('/keuangans', [KeuanganController::class, 'store'])->name('keuangans.store');
    Route::delete('/keuangans/{keuangan}', [KeuanganController::class, 'destroy'])->name('keuangans.destroy');
});
