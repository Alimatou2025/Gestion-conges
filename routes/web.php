<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\JourFerieController;
use App\Http\Controllers\RapportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Espace Administration & Gestionnaires
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Consultation des demandes en attente
    Route::get('/absences/{id}', [AdminController::class, 'showAbsence'])->name('absences.show');

    // Validation des congés
    Route::post('/conges/{id}/valider', [AdminController::class, 'validerConge'])->name('conges.valider');
    Route::post('/conges/{id}/refuser', [AdminController::class, 'refuserConge'])->name('conges.refuser');

    // Validation des absences
    Route::post('/absences/{id}/valider', [AdminController::class, 'validerAbsence'])->name('absences.valider');
    Route::post('/absences/{id}/refuser', [AdminController::class, 'refuserAbsence'])->name('absences.refuser');

    // Gestion complète des agents (CRUD, réservé à l'admin)
    Route::resource('agents', AgentController::class);

    // Consultation de l'historique complet des congés et absences (lecture seule, pas de create)
    Route::get('/conges', [CongeController::class, 'index'])->name('conges.index');
    Route::get('/conges/{conge}', [CongeController::class, 'show'])->name('conges.show');

    Route::get('/historique-absences', [AbsenceController::class, 'index'])->name('absences.index');

    // Jours fériés (gérés par l'admin)
    Route::resource('jours-feries', JourFerieController::class);

    // Rapports
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/rapports/generer', [RapportController::class, 'generer'])->name('rapports.generer');
    Route::get('/rapports/export-pdf', [RapportController::class, 'exportPdf'])->name('rapports.export-pdf');
});

// Espace Employés / Agents
Route::middleware(['auth', 'employee'])->prefix('u')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');

    Route::get('/absences/{id}', [EmployeeController::class, 'showAbsence'])->name('absences.show');

    Route::get('/conges/demande', [EmployeeController::class, 'showDemandeConge'])->name('conges.demande');
    Route::post('/conges/demande', [EmployeeController::class, 'storeDemandeConge']);
    Route::get('/absences/demande', [EmployeeController::class, 'showDemandeAbsence'])->name('absences.demande');
    Route::post('/absences/demande', [EmployeeController::class, 'storeDemandeAbsence']);
});
