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
        $data['status'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
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
    public function showListeCa(Request $request){
        $data['ca_actes_reglements'] = V_CaActesReglement::orderBy('created_at', 'desc')
            ->paginate(20);
        return view('ca/liste-ca')->with($data);
    }
}
