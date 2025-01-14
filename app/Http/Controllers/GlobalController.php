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
        /*
        $results = DB::table('v_dossiers')
            ->where('dossier', 'LIKE', "%{$query}%")
            ->orWhere('nom', 'LIKE', "%{$query}%")
            ->orWhere('date_naissance', 'LIKE', "%{$query}%")
            ->where('is_deleted', 0) // Filtrer les éléments non supprimés
            ->limit(7) // Limite à 7 résultats
            ->get();
        */
                $results = DB::select("
                    SELECT * FROM v_dossiers
                    WHERE (dossier ILIKE ? OR nom ILIKE ? OR TO_CHAR(date_naissance, 'DD-MM-YYYY') ILIKE ?)
                    AND is_deleted = 0
                    LIMIT 7
                ", [
                    "%{$query}%", "%{$query}%", "%{$query}%"
                ]);


        return response()->json($results);
    }

}
