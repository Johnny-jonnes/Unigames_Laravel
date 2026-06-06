<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\JoueurController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ClassementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web - UniGames
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------------------------------------
    // ADMINISTRATION STRICTE (Admin Only)
    // Les routes "create" doivent être AVANT les routes "{id}"
    // pour éviter que Laravel ne les interprète comme un paramètre.
    // ---------------------------------------------------------
    Route::middleware('admin')->group(function () {
        // Éditions - mutation
        Route::get('/editions/create', [EditionController::class, 'create'])->name('editions.create');
        Route::post('/editions', [EditionController::class, 'store'])->name('editions.store');
        Route::get('/editions/{edition}/edit', [EditionController::class, 'edit'])->name('editions.edit');
        Route::put('/editions/{edition}', [EditionController::class, 'update'])->name('editions.update');
        Route::delete('/editions/{edition}', [EditionController::class, 'destroy'])->name('editions.destroy');

        // Facultés - mutation
        Route::get('/facultes/create', [FaculteController::class, 'create'])->name('facultes.create');
        Route::post('/facultes', [FaculteController::class, 'store'])->name('facultes.store');
        Route::get('/facultes/{faculte}/edit', [FaculteController::class, 'edit'])->name('facultes.edit');
        Route::put('/facultes/{faculte}', [FaculteController::class, 'update'])->name('facultes.update');
        Route::delete('/facultes/{faculte}', [FaculteController::class, 'destroy'])->name('facultes.destroy');

        // Disciplines - mutation
        Route::get('/disciplines/create', [DisciplineController::class, 'create'])->name('disciplines.create');
        Route::post('/disciplines', [DisciplineController::class, 'store'])->name('disciplines.store');
        Route::get('/disciplines/{discipline}/edit', [DisciplineController::class, 'edit'])->name('disciplines.edit');
        Route::put('/disciplines/{discipline}', [DisciplineController::class, 'update'])->name('disciplines.update');
        Route::delete('/disciplines/{discipline}', [DisciplineController::class, 'destroy'])->name('disciplines.destroy');

        // Équipes - mutation
        Route::get('/equipes/create', [EquipeController::class, 'create'])->name('equipes.create');
        Route::post('/equipes', [EquipeController::class, 'store'])->name('equipes.store');
        Route::get('/equipes/{equipe}/edit', [EquipeController::class, 'edit'])->name('equipes.edit');
        Route::put('/equipes/{equipe}', [EquipeController::class, 'update'])->name('equipes.update');
        Route::delete('/equipes/{equipe}', [EquipeController::class, 'destroy'])->name('equipes.destroy');

        // Gestion du Staff
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/users', [\App\Http\Controllers\UsersManagementController::class, 'index'])->name('users.index');
            Route::get('/users/create', [\App\Http\Controllers\UsersManagementController::class, 'create'])->name('users.create');
            Route::post('/users', [\App\Http\Controllers\UsersManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [\App\Http\Controllers\UsersManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [\App\Http\Controllers\UsersManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [\App\Http\Controllers\UsersManagementController::class, 'destroy'])->name('users.destroy');
        });
    });

    // ---------------------------------------------------------
    // GESTION DU CONTENU (Admin + Staff)
    // Les routes "create" avant les routes "{id}" aussi ici.
    // ---------------------------------------------------------
    Route::middleware('can.manage')->group(function () {
        // Joueurs - mutation
        Route::get('/joueurs/create', [JoueurController::class, 'create'])->name('joueurs.create');
        Route::post('/joueurs', [JoueurController::class, 'store'])->name('joueurs.store');
        Route::get('/joueurs/{joueur}/edit', [JoueurController::class, 'edit'])->name('joueurs.edit');
        Route::put('/joueurs/{joueur}', [JoueurController::class, 'update'])->name('joueurs.update');
        Route::delete('/joueurs/{joueur}', [JoueurController::class, 'destroy'])->name('joueurs.destroy');

        // Matchs - mutation
        Route::get('/matchs/create', [MatchController::class, 'create'])->name('matchs.create');
        Route::post('/matchs', [MatchController::class, 'store'])->name('matchs.store');
        Route::get('/matchs/{match}/edit', [MatchController::class, 'edit'])->name('matchs.edit');
        Route::put('/matchs/{match}', [MatchController::class, 'update'])->name('matchs.update');
        Route::delete('/matchs/{match}', [MatchController::class, 'destroy'])->name('matchs.destroy');
        Route::post('/matchs/{match}/score', [MatchController::class, 'saisirScore'])->name('matchs.score');
    });

    // ---------------------------------------------------------
    // LECTURE SEULE (Accessible par tous les rôles connectés)
    // Ces routes avec {paramètre} doivent être APRÈS les "create".
    // ---------------------------------------------------------
    Route::get('/editions', [EditionController::class, 'index'])->name('editions.index');
    Route::get('/editions/{edition}', [EditionController::class, 'show'])->name('editions.show');
    Route::get('/editions/{edition}/arbre', [EditionController::class, 'arbre'])->name('editions.arbre');

    Route::get('/facultes', [FaculteController::class, 'index'])->name('facultes.index');
    Route::get('/facultes/{faculte}', [FaculteController::class, 'show'])->name('facultes.show');

    Route::get('/disciplines', [DisciplineController::class, 'index'])->name('disciplines.index');
    Route::get('/disciplines/{discipline}', [DisciplineController::class, 'show'])->name('disciplines.show');

    Route::get('/equipes', [EquipeController::class, 'index'])->name('equipes.index');
    Route::get('/equipes/{equipe}', [EquipeController::class, 'show'])->name('equipes.show');

    Route::get('/joueurs', [JoueurController::class, 'index'])->name('joueurs.index');

    Route::get('/matchs', [MatchController::class, 'index'])->name('matchs.index');
    Route::get('/matchs/{match}', [MatchController::class, 'show'])->name('matchs.show');

    Route::get('/classements', [ClassementController::class, 'index'])->name('classements.index');
});

require __DIR__.'/auth.php';
