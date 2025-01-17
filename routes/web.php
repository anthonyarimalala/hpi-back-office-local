<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('login', function() { return view('authentification/login'); });
Route::post('login', [ \App\Http\Controllers\Authentification\LoginController::class, 'login'])->name('login');
Route::post('logout', [\App\Http\Controllers\Authentification\LoginController::class, 'logout'])->name('logout');
Route::get('register', function() { return view('authentification/register'); });
Route::post('register', [ \App\Http\Controllers\Authentification\LoginController::class, 'register'])->name('register');

Route::middleware('auth')->group(function() {
    Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard']);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // Recherche
    Route::get('/search', [\App\Http\Controllers\GlobalController::class, 'search'])->name('search');


    // section: patients
    Route::get('ajouter-patient', [\App\Http\Controllers\Patient\PatientController::class, 'showInsertPatient']);
    Route::post('ajouter-patient', [\App\Http\Controllers\Patient\PatientController::class, 'insertPatient'])->name('ajouter.patient');

    // section: dossiers
    Route::get('dossiers', [\App\Http\Controllers\Dossier\DossierController::class, 'showDossiers'])->name('dossiers');
    Route::get('modifier-dossier/{dossier}', [\App\Http\Controllers\Dossier\DossierController::class, 'showModifierDossier']);
    Route::post('modifier-dossier', [\App\Http\Controllers\Dossier\DossierController::class, 'modifierDossier'])->name('modifier.dossier');
    Route::get('supprimer-mutuelle/{dossier}/{mutuelle}', [\App\Http\Controllers\Dossier\DossierController::class, 'supprimerMutuelle'])->name('supprimer.mutuelle');

    // section: devis
    Route::post('modifier-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'modifierDevis']);
    Route::get('{dossier}/devis/{id_devis}/modifier', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'showModifierDevis']);
    Route::get('liste-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getAllListeDevis']);
    Route::get('{dossier}/devis/{id_devis}/detail', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getDevis'])->name('devis.detail');;
    Route::get('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'nouveauDevis']);
    Route::post('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'creerDevis']);
    Route::get('{dossier}/liste-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getListeDevis'])->name('liste-devis');
    Route::get('devis/{dossier}', [\App\Http\Controllers\Dossier\DossierController::class, 'showDetailDossier']);
    Route::get('devis/modifier/{dossier}', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'showModifierDevis']);

    // section: prothèse
    Route::get('{dossier}/prothese/{id_devis}/detail', [\App\Http\Controllers\Dossier\Prothese\ProtheseController::class, 'showProthese']);
    Route::get('{dossier}/prothese/{id_devis}/modifier', [\App\Http\Controllers\Dossier\Prothese\ProtheseController::class, 'showModifierProthese']);
    Route::post('modifier-prothese', [\App\Http\Controllers\Dossier\Prothese\ProtheseController::class, 'modifierProthese']);

    // section: chèque
    Route::get('{dossier}/cheque/{id_devis}/detail', [\App\Http\Controllers\Dossier\Cheque\ChequeController::class, 'showCheque'])->name('cheque.detail');
    Route::get('{dossier}/cheque/{id_devis}/modifier', [\App\Http\Controllers\Dossier\Cheque\ChequeController::class, 'showModifierCheque']);
    Route::post('modifier-cheque', [\App\Http\Controllers\Dossier\Cheque\ChequeController::class, 'modifierCheque']);

    // section: autres
    Route::get('liste-praticiens', [\App\Http\Controllers\Autre\PraticienController::class, 'showPraticiens']);
    Route::post('save-praticien', [\App\Http\Controllers\Autre\PraticienController::class, 'savePraticien']);
    Route::post('delete-praticien', [\App\Http\Controllers\Autre\PraticienController::class, 'deletePraticien']);
    Route::get('liste-dossier-status', [\App\Http\Controllers\Autre\DossierStatusController::class, 'showDossierStatus']);
    Route::post('save-dossier-status', [\App\Http\Controllers\Autre\DossierStatusController::class, 'saveDossierStatus']);
    Route::post('delete-dossier-status', [\App\Http\Controllers\Autre\DossierStatusController::class, 'deleteDossierStatus']);

    // section: dashboard
    Route::get('dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard'])->name('dashboard');

    // section: gestion
        //utilisateur
        Route::get('utilisateurs',[\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'showListeUtilisateurs']);
        Route::post('creer-utilisateur', [\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'creerUtilisateur']);
        Route::get('effacer-utilisateur/{code_u}', [\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'effacerUtilisateur']);


});


