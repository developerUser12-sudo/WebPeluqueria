<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BloqueosHorariosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservarCitaController;
use App\Http\Controllers\CitasController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
    

});

Route::middleware('auth')->group(function () {
    Route::patch('/cambiar-contrasena', [ProfileController::class, 'updatePassword'])->name('cuenta.password');
    Route::patch('/cambiar-email', [ProfileController::class, 'updateEmail'])->name('cuenta.email');
    Route::patch('/cambiar-datos', [ProfileController::class, 'updateDatos'])->name('cuenta.datos');
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('cuenta', [ProfileController::class, 'updateProfile'])->middleware('verified');
});
Route::middleware('guest:admin')->group(function () {
    Route::get('login-admin', [LoginAdminController::class, 'create'])
        ->name('admin.loginadmin');

    Route::post('login-admin', [LoginAdminController::class, 'store'])
        ->name('admin.loginadmin.submit');
});
Route::middleware('auth:admin')->group(function () {

    Route::get('admin', [ReservarCitaController::class, 'show']);

    Route::post('logout-admin', [LoginAdminController::class, 'destroy'])
        ->name('admin.logout');

    Route::post('bloqueos', [BloqueosHorariosController::class, 'store'])
        ->name('bloqueos.store');
    Route::get('/cita/{id}/editar', [CitasController::class, 'editarCitaView'])->name('citas.edit');
    Route::put('/cita/{id}', [CitasController::class, 'editarCita'])->name('citas.update');
    Route::delete('/citas/{id}', [CitasController::class, 'eliminarCita'])->name('citas.destroy');
});
