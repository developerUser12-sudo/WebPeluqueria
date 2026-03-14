<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservarCitaController;
Route::get('/', function () {
    return view('homepage');
});
Route::get('politica-de-privacidad', function () {
    return view('politica-privacidad');
});
Route::get('aviso-legal', function () {
    return view('aviso-legal');
});
Route::get('reservar', [ReservarCitaController::class, 'create'])->name('reservar');
Route::post('reservar', [ReservarCitaController::class, 'reservar'])->name('reservar');
Route::get('cita-confirmada/{id}', [ReservarCitaController::class, 'confirmada'])->name('cita-confirmada');
Route::get('cita-confirmada/{id}/calendar', [ReservarCitaController::class, 'calendar'])->name('calendario');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
