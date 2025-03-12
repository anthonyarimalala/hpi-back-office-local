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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    //
    public function exportV_Ca(Request $request)
    {
        $date_ca_modif_debut = $request->input('date_ca_modif_debut');
        $date_ca_modif_fin = $request->input('date_ca_modif_fin');
        $date_ca_create_debut = $request->input('date_ca_create_debut');
        $date_ca_create_fin = $request->input('date_ca_create_fin');
        $withFilters = $request->input('withFilters', []);


        /*
        $v_ca = V_CaActesReglement::where('date_derniere_modif', '>=', $date_ca_modif_debut)
            ->where('date_derniere_modif', '<=', $date_ca_modif_fin)
            ->orderBy('created_at', 'desc')
            ->get();
        */

        $filters = session()->get('ca_filters', []);
        $m_v_ca = new V_CaActesReglement();
        $query = $m_v_ca->query();
        if (count($withFilters) > 0){
            if ($filters)
                $m_v_ca->scopeFilter($query, $filters);
        }
        if ($date_ca_modif_debut && $date_ca_create_debut!=''){
            $query->where('date_derniere_modif' , '>=' , $date_ca_modif_debut);
        }
        if ($date_ca_modif_fin && $date_ca_create_fin!=''){
            $query->where('date_derniere_modif' , '<=' , $date_ca_create_fin);
        }
        if ($date_ca_create_debut && $date_ca_create_debut!=''){
            $query->where('date_derniere_modif' , '>=' , $date_ca_create_debut);
        }
        if ($date_ca_create_fin && $date_ca_create_fin!=''){
            $query->orderBy('created_at', '<=', $date_ca_create_fin);
        }

        $v_ca = $query->orderBy('created_at', 'desc')
            ->get();

        $praticiens = DB::select("SELECT
                                                            praticien
                                                        FROM ca_actes_reglements
                                                        WHERE date_derniere_modif >= ? AND date_derniere_modif <= ?
                                                        GROUP BY praticien", [$date_ca_modif_debut, $date_ca_modif_fin]);
        return Excel::download(new V_CaExport($v_ca, $praticiens), 'ca'.Carbon::parse($date_ca_modif_debut)->format('d-m-Y').'a'.Carbon::parse($date_ca_modif_fin)->format('d-m-Y').'.xlsx');
    }
    public function exportV_Devis(Request $request)
    {
        $withFilters = $request->input('withFilters', []);
        $date_devis_debut = $request->input('date_devis_debut');
        $date_devis_fin = $request->input('date_devis_fin');

        $filters = session()->get('devis_filters', []);
        $m_v_devis = new V_Devis();
        $query = $m_v_devis->query(); // Crée une requête de base
        // echo('count($withFilters): '.count($withFilters));

        if (count($withFilters) > 0){
            if ($filters)
                $m_v_devis->scopeFiltrer($query, $filters);
        }
        $v_devis = $query->where('date', '>=', $date_devis_debut)
            ->where('date', '<=', $date_devis_fin)
            ->orderBy('date', 'asc')
            ->get();
        return Excel::download(new V_DevisExport($v_devis), $date_devis_debut . 'a' . $date_devis_fin . '.xlsx');
    }
    public function showDevisExportView(Request $request)
    {
        $date_devis_debut = $request->input('date_devis_debut');
        $date_devis_fin = $request->input('date_devis_fin');
        $data['data'] = V_Devis::where('date', '>=', $date_devis_debut)
            ->where('date', '<=', $date_devis_fin)
            ->orderBy('date', 'asc')
            ->get();
        return view('orders')->with($data);
    }
    public function showCaExportView(Request $request)
    {
        $date_ca_modif_debut = $request->input('date_ca_modif_debut');
        $date_ca_modif_fin = $request->input('date_ca_modif_fin');
        $data['data'] = V_CaActesReglement::where('date_derniere_modif', '>=', $date_ca_modif_debut)
            ->where('date_derniere_modif', '<=', $date_ca_modif_fin)
            ->orderBy('date_derniere_modif', 'desc')
            ->get();
        $data['praticiens'] = DB::select("SELECT
                                                            praticien
                                                        FROM ca_actes_reglements
                                                        WHERE date_derniere_modif >= ? AND date_derniere_modif <= ?
                                                        GROUP BY praticien", [$date_ca_modif_debut, $date_ca_modif_fin]);
        return view('export-ca')->with($data);
    }

}
