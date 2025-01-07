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
    Route::get('/',function () { return view('test-view'); });
});
Route::middleware(['auth', 'role:user'])->group(function () {

    // section: patients
    Route::get('ajouter-patient', [\App\Http\Controllers\Patient\PatientController::class, 'showInsertPatient']);
    Route::post('ajouter-patient', [\App\Http\Controllers\Patient\PatientController::class, 'insertPatient'])->name('ajouter.patient');

    // section: dossiers
    Route::get('dossiers', [\App\Http\Controllers\Dossier\DossierController::class, 'showDossiers']);
    Route::get('modifier-dossier/{dossier}', [\App\Http\Controllers\Dossier\DossierController::class, 'showModifierDossier']);
    Route::post('modifier-dossier', [\App\Http\Controllers\Dossier\DossierController::class, 'modifierDossier'])->name('modifier.dossier');
    Route::get('supprimer-mutuelle/{dossier}/{mutuelle}', [\App\Http\Controllers\Dossier\DossierController::class, 'supprimerMutuelle'])->name('supprimer.mutuelle');

    // section: devis
    Route::get('{dossier}/devis-prothese-chq/{id_devis}', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getDevis']);
    Route::get('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'nouveauDevis']);
    Route::post('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'creerDevis']);
    Route::get('{dossier}/liste-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getListeDevis'])->name('liste-devis');
    Route::get('devis-prothese-chq/{dossier}', [\App\Http\Controllers\Dossier\DossierController::class, 'showDetailDossier']);
    Route::get('devis-prothese-chq/modifier/{dossier}', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'showModifierDevis']);
});


