<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlobalController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Recherche dans la vue v_dossiers
        $results = DB::table('v_dossiers')
            ->where('dossier', 'LIKE', "%{$query}%")
            ->orWhere('nom', 'LIKE', "%{$query}%")
            ->orWhere('date_naissance', 'LIKE', "%{$query}%")
            ->where('is_deleted', 0) // Filtrer les éléments non supprimés
            ->limit(7) // Limite à 7 résultats
            ->get();

        return response()->json($results);
    }

}
