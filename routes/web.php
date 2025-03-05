<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Participant\EventRegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (página principal após login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rotas para Administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('/events', EventController::class);

    Route::get('/events/{event}/registrations', [EventController::class, 'registrations'])->name('events.registrations');
});

// Grupo de rotas autenticadas (Perfil)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de rotas para Participantes (Visualização e inscrição em eventos)
Route::middleware('auth')->prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventRegistrationController::class, 'index'])->name(name: 'list');                                // Lista de eventos
    Route::post('/register/{event}', [EventRegistrationController::class, 'register'])->name('register');              // Inscrição
    Route::delete('/unregister/{event}', [EventRegistrationController::class, 'unregister'])->name('unregister');      // Cancelamento
    Route::get('/my-registrations', [EventRegistrationController::class, 'myRegistrations'])->name('myRegistrations'); // Minhas inscrições
});

// Arquivo de autenticação
require __DIR__ . '/auth.php';
