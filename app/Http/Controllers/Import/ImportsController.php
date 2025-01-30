<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\DevisImport;
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

        // Récupérer le fichier téléchargé
        $file = $request->file('devisFile');

        DB::delete('DELETE FROM import_devis');

        // Importer le fichier avec la classe d'import
        Excel::import(new DevisImport, $file);

        // Retourner après l'importation
        return back()->with('success', 'Fichier importé avec succès!');
    }
    public function showImports(){
        return view('imports/imports');
    }
}
