<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\JourFerieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RapportController;

// Routes authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (connecté obligatoire)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Agents
    Route::resource('agents', AgentController::class);

    // Congés
    Route::resource('conges', CongeController::class);

    // Absences
    Route::resource('absences', AbsenceController::class);

    // Jours fériés
    Route::resource('jours-feries', JourFerieController::class);

    // Rapports
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/rapports/generer', [RapportController::class, 'generer'])->name('rapports.generer');
    Route::get('/rapports/export-pdf', [RapportController::class, 'exportPdf'])->name('rapports.export-pdf');

    // Admin seulement
Route::middleware('auth')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
});
