<?php

namespace App\Http\Controllers\Export;

use App\Exports\V_CaExport;
use App\Exports\V_DevisExport;
use App\Http\Controllers\Controller;
use App\Models\dossier\DossierStatus;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    //
    public function exportV_Ca(Request $request)
    {
        $date_ca_modif_debut = $request->input('date_ca_modif_debut');
        $date_ca_modif_fin = $request->input('date_ca_modif_fin');
        $v_ca = V_CaActesReglement::where('date_derniere_modif', '>=', $date_ca_modif_debut)
            ->where('date_derniere_modif', '<=', $date_ca_modif_fin)
            ->orderBy('date_derniere_modif', 'desc')
            ->get();
        return Excel::download(new V_CaExport($v_ca), 'ca'.Carbon::parse($date_ca_modif_debut)->format('d-m-Y').'a'.Carbon::parse($date_ca_modif_fin)->format('d-m-Y').'.xlsx');
    }
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
