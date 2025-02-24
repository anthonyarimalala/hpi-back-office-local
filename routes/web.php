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
    Route::get('/', function (){
        return redirect()->route('dashboard');
    });
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // Recherche
    Route::get('/search', [\App\Http\Controllers\GlobalController::class, 'search'])->name('search');
    Route::get('/search-dossier', [\App\Http\Controllers\GlobalController::class, 'searchDossier'])->name('search.dossier');


    // section: patients
    Route::get('ajouter-dossier', [\App\Http\Controllers\Dossier\DossierController::class, 'showInsertDossier']);
    Route::post('ajouter-dossier', [\App\Http\Controllers\Dossier\DossierController::class, 'insertDossier'])->name('ajouter.patient');

    // section: dossiers
    Route::get('dossiers', [\App\Http\Controllers\Dossier\DossierController::class, 'showDossiers'])->name('dossiers');
    Route::get('modifier-dossier/{dossier}', [\App\Http\Controllers\Dossier\DossierController::class, 'showModifierDossier']);
    Route::post('modifier-dossier', [\App\Http\Controllers\Dossier\DossierController::class, 'modifierDossier'])->name('modifier.dossier');
    Route::get('{dossier}/details', [\App\Http\Controllers\Dossier\DossierController::class, 'getDetailDossier'])->name('dossier.detail');

    // section: devis
    Route::post('modifier-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'modifierDevis']);
    Route::get('{dossier}/devis/{id_devis}/modifier', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'showModifierDevis']);
    Route::get('liste/devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getAllListeDevis']);
    Route::get('{dossier}/devis/{id_devis}/detail', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'getDevis'])->name('devis.detail');;
    Route::get('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'nouveauDevis']);
    Route::post('{dossier}/nouveau-devis', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'creerDevis']);
    Route::get('devis/nouveau', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'showNouveauDevis']);
    Route::post('devis/nouveau', [\App\Http\Controllers\Dossier\Devis\DevisController::class, 'creerDevisSansDossier']);

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

    Route::get('liste-pose-status', [\App\Http\Controllers\Autre\ProtheseTravauxStatusController::class, 'showProtheseTravauxStatus']);
    Route::post('save-pose-status', [\App\Http\Controllers\Autre\ProtheseTravauxStatusController::class, 'saveProtheseTravauxStatus']);
    Route::post('delete-pose-status', [\App\Http\Controllers\Autre\ProtheseTravauxStatusController::class, 'deleteProtheseTravauxStatus']);

    Route::get('liste-travaux', [\App\Http\Controllers\Autre\InfoChequeTravauxDevisController::class, 'showTravauxDevis']);
    Route::get('liste-situation-cheque', [\App\Http\Controllers\Autre\InfoChequeSituationChequeController::class, 'showSituationCheque']);
    Route::get('liste-nature-cheque', [\App\Http\Controllers\Autre\InfoChequeNatureChequeController::class, 'showNatureCheque']);

    // section: dashboard
    Route::get('dashboard/overview', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('dashboard/rappels', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboardRappels'])->name('dashboard.rappel');
    Route::get('dashboard/c-a', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboardCa']);




    // section: gestion
        //utilisateur
        Route::get('utilisateurs',[\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'showListeUtilisateurs']);
        Route::post('creer-utilisateur', [\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'creerUtilisateur']);
        Route::get('effacer-utilisateur/{code_u}', [\App\Http\Controllers\Gestion\GestionUtilisateurController::class, 'effacerUtilisateur']);

    // section: historique
    Route::get('historiques/modif-chq', [\App\Http\Controllers\Hist\HistoriqueController::class, 'showHistCheque']);
    Route::get('historiques/modif-pro', [\App\Http\Controllers\Hist\HistoriqueController::class, 'showHistProthese']);
    Route::get('historiques/modif-dev', [\App\Http\Controllers\Hist\HistoriqueController::class, 'showHistDevis']);
    Route::get('historiques/modif-ca', [\App\Http\Controllers\Hist\HistoriqueController::class, 'showHistCa']);

    // section: ca
    Route::get('liste-ca', [\App\Http\Controllers\Ca\CaController::class, 'showListeCa'])->name('liste.ca');
    Route::get('ca/{id_ca}/{dossier}/modifier', [\App\Http\Controllers\Ca\CaController::class, 'showModifierCa']);
    Route::post('ca/modifier', [\App\Http\Controllers\Ca\CaController::class, 'updateCa']);
    Route::get('ca/nouveau', [\App\Http\Controllers\Ca\CaController::class, 'showNouveauCa']);
    Route::get('ca/nouveau/{dossier}', [\App\Http\Controllers\Ca\CaController::class, 'showNouveauCaWithDossier']);
    Route::post('ca/nouveau', [\App\Http\Controllers\Ca\CaController::class, 'saveCa']);
    Route::get('/get-patient-details', [\App\Http\Controllers\Ca\CaController::class, 'getPatientDetails'])->name('get.patient.details');

    // section: imports
    Route::get('imports', [\App\Http\Controllers\Import\ImportsController::class, 'showImports']);
    Route::post('devis/import', [\App\Http\Controllers\Import\ImportsController::class, 'importerDevis']);
    Route::post('ca/import', [\App\Http\Controllers\Import\ImportsController::class, 'importerCa'])->name('ca.import');
    // section: exports
    Route::get('v_devis/export/', [\App\Http\Controllers\Export\ExportsController::class, 'exportV_Devis'])->name('v_devis.export');
    Route::get('ca/export', [\App\Http\Controllers\Export\ExportsController::class, 'exportV_Ca'])->name('v_ca.export');

    // section: erreurs
    Route::get('erreur-import-1', [\App\Http\Controllers\Error\ErrorImportController::class, 'showDevisErrorImports']);
    Route::get('erreur-import-2', [\App\Http\Controllers\Error\ErrorImportController::class, 'showCaErrorImports']);

    Route::get('import-ca-view', function (){ return view('export-ca'); });

});


