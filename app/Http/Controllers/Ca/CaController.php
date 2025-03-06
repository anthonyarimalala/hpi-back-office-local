<?php

namespace App\Http\Controllers\Ca;

use App\Http\Controllers\Controller;
use App\Models\ca\CaActesReglement;
use App\Models\devis\Devis;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\hist\H_CaActesReglement;
use App\Models\praticien\Praticien;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CaController extends Controller
{
    //
    public function getPatientDetails(Request $request){
        $dossier = $request->query('dossier');
        $m_v_devis = \App\Models\views\V_Devis::where('dossier', $dossier)->orderBy('date', 'desc')->first();
        if ($m_v_devis) {
            return response()->json([
                'success' => true,
                'nom_patient' => $m_v_devis->nom,
                'statut' => $m_v_devis->status,
                'praticien' => $m_v_devis->praticien,
                'mutuelle' => $m_v_devis->mutuelle
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function saveCa(Request $request)
    {
        $m_ca = new CaActesReglement();
        //echo ('input: '.$request->input('date_derniere_modif'). '<br>');
        $m_ca->saveCa($request);

        $dossier = $request->input('dossiers');
        $m_dossier = Dossier::where('dossier', $dossier)->first();
        if(!$m_dossier) return back()->withErrors('Le dossier "' . $dossier . '" n\'existe pas.')->withInput();
        return redirect()->route('liste.ca');

    }
    public function updateCa(Request $request)
    {
        $m_ca = new CaActesReglement();
        $m_ca->updateCa($request);
        return redirect()->route('liste.ca');
    }
    public function showNouveauCaWithDossier($dossier)
    {
        $data['m_v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('is_deleted', 0)
            ->orderBy('date', 'desc')
            ->first();
        $data['status'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();
        return view('ca/nouveau/nouveau-ca-with-dossier')->with($data);
    }
    public function showNouveauCa()
    {
        $data['status'] = DossierStatus::where('is_deleted', 0)
            ->where('status','!=', '')
            ->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')
            ->get();
        return view('ca/nouveau/nouveau-ca')->with($data);
    }
    public function showModifierCa($id_ca, $dossier)
    {
        $data['status'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();
        $data['v_ca_actes_reglement'] = V_CaActesReglement::where('id', $id_ca)->where('dossier', $dossier)->first();
        $data['hists'] = H_CaActesReglement::orderBy('created_at', 'desc')
            ->where('id_ca_actes_reglement', $id_ca)
            ->paginate(15);
        if(!$data['v_ca_actes_reglement']) return back();
        return view('ca/modifier/modifier-ca')->with($data);
    }
    public function getFilterCa(Request $request){
        $filters = [
            'date_derniere_modif_debut' => $request->input('date_derniere_modif_debut'),
            'date_derniere_modif_fin' => $request->input('date_derniere_modif_fin'),
            'status' => $request->input('status'),
            'praticiens' => $request->input('praticiens')
        ];
        session()->put('ca_filters', $filters);
        return redirect('liste-ca');
    }
    public function showListeCa(Request $request){
        $filters = session()->get('ca_filters', []);
        $m_v_ca = new V_CaActesReglement();
        $query = $m_v_ca->query();
        if ($filters) $m_v_ca->scopeFilter($query, $filters);
        $m_v_cas = $query->orderBy('created_at', 'desc')
            ->where('is_deleted', 0)
            ->paginate(20);
        $data['ca_actes_reglements'] = $m_v_cas;
        $data['filters'] = $filters;
        $data['dossier_statuss'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('ca/liste-ca')->with($data);
    }
}
