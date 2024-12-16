<?php

use App\Http\Controllers\{LoginController, LogoutController, HomeController, AppointmentController};
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    // Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    // Route::put('/appointments/{appointment}/update', [AppointmentController::class, 'update'])->name('appointments.update');
    // Route::delete('/appointments/destroy', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::post('/logout', LogoutController::class)->name('logout');
});
