<?php

namespace App\Http\Controllers\Export;

use App\Exports\V_DevisExport;
use App\Http\Controllers\Controller;
use App\Models\dossier\DossierStatus;
use App\Models\views\V_Devis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    //
    public function exportV_Devis(Request $request)
    {
        $date_devis_debut = $request->input('date_devis_debut');
        $date_devis_fin = $request->input('date_devis_fin');
        $v_devis = V_Devis::where('date', '>=', $date_devis_debut)
            ->where('date', '<=', $date_devis_fin)
            ->orderBy('date', 'asc')
            ->get();
        return Excel::download(new V_DevisExport($v_devis), $date_devis_debut . 'a' . $date_devis_fin . '.xlsx');
    }
}
