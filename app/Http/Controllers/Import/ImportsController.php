<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\DevisImport;
use App\Models\devis\Devis;
use App\Models\dossier\Dossier;
use App\Models\import\ImportDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    //
    public function importerDevis(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'devisFile' => 'required|file|mimes:xlsx,xls',
        ]);
        $file = $request->file('devisFile');

        DB::delete('DELETE FROM import_devis');

        // Importer le fichier avec la classe d'import
        Excel::import(new DevisImport($file), $file);

        $m_import_deviss = ImportDevis::all();
        foreach ($m_import_deviss as $mid){
            $m_dossier = Dossier::firstOrNew(['dossier' => $mid->dossier]);
            $m_dossier->nom = $mid->nom;
            $m_dossier->status = $mid->status;
            $m_dossier->mutuelle = $mid->mutuelle;
            $m_dossier->save();
            $m_devis = Devis::firstOrNew(['dossier' => $mid->dossier, 'date' => $mid->date]);
            $m_devis->status = $mid->status;
            $m_devis->mutuelle = $mid->mutuelle;
            $m_devis->date = $mid->date;
            $m_devis->montant = $mid->montant;
            $m_devis->devis_signe = $mid->devis_signe;
            $m_devis->praticien = $mid->praticien;
            $m_devis->observation = $mid->devis_observation;
            $m_devis->save();
        }

        //return back()->with('success', 'Fichier importé avec succès!');
    }
    public function showImports(){
        return view('imports/imports');
    }
}
