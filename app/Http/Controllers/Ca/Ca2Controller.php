<?php

namespace App\Http\Controllers\ca;

use App\Http\Controllers\Controller;
use App\Models\ca\CaActesReglement;
use App\Models\ca\CaGeneral;
use App\Models\ca\L_CaActesReglement;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\hist\H_CaActesReglement;
use App\Models\praticien\Praticien;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Ca2Controller extends Controller
{

    // debut: insertion d'un acte de CA s'il y'en a déjà
    public function insertNouveauCaActe(Request $request, $id_ca){
        $m_l_ca_actes_reglement = L_CaActesReglement::insertCaActesReglement($request, $id_ca);
        return redirect('liste-ca');
    }
    public function showNouveauCaActe($id_ca){
        $data['m_ca'] = V_CaActesReglement::where('id', $id_ca)->first();
        $data['m_praticiens'] = Praticien::where('praticien', '!=', '')->where('is_deleted', 0)->get();
        return view('ca/nouveau/actes/nouveau-ca-acte')->with($data);
    }
    // fin: insertion d'un acte de CA s'il y'en a déjà
    public function showUpdateCa($id_ca_actes_reglement, $dossier){
        $data['v_ca_actes_reglement'] = V_CaActesReglement::where('id_ca_actes_reglement', $id_ca_actes_reglement)->where('dossier', $dossier)->first();
        if(!$data['v_ca_actes_reglement']){
            return back();
        }
        $data['status'] = DossierStatus::orderBy('ordre', 'desc')->where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();

        $data['hists'] = H_CaActesReglement::orderBy('created_at', 'desc')
            ->where('id_ca_actes_reglement', $id_ca_actes_reglement)
            ->paginate(15);
        if(!$data['v_ca_actes_reglement']) return back();
        return view('ca/modifier/modifier-ca')->with($data);
    }
    public function updateCa(Request $request, $id_ca_actes_reglement){
        $m_l_ca_actes_reglement = L_CaActesReglement::updateCaActesReglement($request, $id_ca_actes_reglement);
        return redirect('liste-ca');
    }
    //Insertion du CA s'il n'y a pas encore d'acte
    public function insertCa(Request $request){
        $m_ca = CaGeneral::createCa($request);
        $m_l_ca_actes_reglement = L_CaActesReglement::insertCaActesReglement($request, $m_ca->id);
        return redirect('liste-ca');
    }
    public function getFilterCa(Request $request){
        $filters = [
            'date_derniere_modif_debut' => $request->input('date_derniere_modif_debut'),
            'date_derniere_modif_fin' => $request->input('date_derniere_modif_fin'),
            'date_ca_debut' => $request->input('date_ca_debut'),
            'date_ca_fin' => $request->input('date_ca_fin'),
            'status' => $request->input('status'),
            'praticiens' => $request->input('praticiens'),
            'montant_min_cotation' => $request->input('montant_min_cotation'),
            'montant_max_cotation' => $request->input('montant_max_cotation'),
            'non_regle_cotation' => $request->input('non_regle_cotation', []),
            'regle_cotation' => $request->input('regle_cotation', []),
            'montant_min_secu' => $request->input('montant_min_secu'),
            'montant_max_secu' => $request->input('montant_max_secu'),
            'non_regle_secu' => $request->input('non_regle_secu', []),
            'montant_min_mut' => $request->input('montant_min_mut'),
            'montant_max_mut' => $request->input('montant_max_mut'),
            'non_regle_mut' => $request->input('non_regle_mut', []),
            'montant_min_patient' => $request->input('montant_min_patient'),
            'montant_max_patient' => $request->input('montant_max_patient'),
            'non_regle_patient' => $request->input('non_regle_patient', []),
        ];
        session()->put('ca_filters', $filters);
        return redirect('liste-ca');
    }
    public function reinitializeFilterCa(){
        session()->forget('ca_filters');
        return back();
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
    public function getPatientDetails(Request $request){
        $dossier = $request->query('dossier');

        $m_dossier = Dossier::where('dossier', $dossier)->first();
        $m_v_devis = \App\Models\views\V_Devis::where('dossier', $dossier)->orderBy('date', 'desc')->first();
        if ($m_v_devis) {
            return response()->json([
                'success' => true,
                'nom_patient' => $m_v_devis->nom,
                'statut' => $m_v_devis->status,
                'praticien' => $m_v_devis->praticien,
                'mutuelle' => $m_v_devis->mutuelle
            ]);
        }
        else if ($m_dossier) {
            return response()->json([
                'success' => true,
                'nom_patient' => $m_dossier->nom,
                'statut' => $m_dossier->status,
                'mutuelle' => $m_dossier->mutuelle
            ]);
        }
        else {
            return response()->json(['success' => false]);
        }
    }
    public function showNouveauCaWithDossier($dossier)
    {
        $data['m_dossier'] = Dossier::where('dossier', $dossier)->first();
        $data['m_v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('is_deleted', 0)
            ->orderBy('date', 'desc')
            ->first();
        $data['status'] = DossierStatus::orderBy('ordre', 'desc')->where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();
        return view('ca/nouveau/nouveau-ca-with-dossier')->with($data);
    }
    public function showModifierCa($id_ca, $dossier)
    {
        $data['status'] = DossierStatus::orderBy('ordre', 'desc')->where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')->get();
        $data['v_ca_actes_reglement'] = V_CaActesReglement::where('id_ca_actes_reglement', $id_ca)->where('dossier', $dossier)->first();
        $data['hists'] = H_CaActesReglement::orderBy('created_at', 'desc')
            ->where('id_ca_actes_reglement', $id_ca)
            ->paginate(15);
        if(!$data['v_ca_actes_reglement']) return back();
        return view('ca/modifier/modifier-ca')->with($data);
    }
    public function deleteCa($id_ca){
        $m_h_ca = new H_CaActesReglement();
        $m_ca = CaActesReglement::find($id_ca);
        $m_h_ca->code_u = Auth::user()->code_u;
        $m_h_ca->nom = Auth::user()->prenom. ' '. Auth::user()->nom;
        $m_h_ca->id_ca_actes_reglement = $id_ca;
        $m_h_ca->dossier = $m_ca->dossier;
        $m_h_ca->categorie = 'delete';
        $m_h_ca->action .= "<strong>Date dernière modif: </strong> " . $m_ca->date_derniere_modif . "\n";
        $m_h_ca->action .= "<strong>Dossier: </strong> " . $m_ca->dossier . "\n";
        $m_h_ca->action .= "<strong>Nom patient: </strong> " . $m_ca->nom_patient . "\n";
        $m_h_ca->action .= "<strong>Statut: </strong> " . $m_ca->statut . "\n";
        $m_h_ca->action .= "<strong>Mutuelle: </strong> " . $m_ca->mutuelle . "\n";
        $m_h_ca->action .= "<strong>Praticien: </strong> " . $m_ca->praticien . "\n";
        $m_h_ca->action .= "<strong>Nom acte: </strong> " . $m_ca->nom_acte . "\n";
        $m_h_ca->action .= "<strong>Cotation: </strong> " . $m_ca->cotation . "\n";
        $m_h_ca->action .= "<strong>Contrôle sécurisation: </strong> " . $m_ca->controle_securisation . "\n";
        $m_h_ca->action .= "<strong>RO part sécu: </strong> " . $m_ca->ro_part_secu . "\n";
        $m_h_ca->action .= "<strong>RO virement reçu: </strong> " . $m_ca->ro_virement_recu . "\n";
        $m_h_ca->action .= "<strong>RO indus payé: </strong> " . $m_ca->ro_indus_paye . "\n";
        $m_h_ca->action .= "<strong>RO indus en attente: </strong> " . $m_ca->ro_indus_en_attente . "\n";
        $m_h_ca->action .= "<strong>RO indus irrécouvrable: </strong> " . $m_ca->ro_indus_irrecouvrable . "\n";
        $m_h_ca->action .= "<strong>Part mutuelle: </strong> " . $m_ca->part_mutuelle . "\n";
        $m_h_ca->action .= "<strong>RCS virement: </strong> " . $m_ca->rcs_virement . "\n";
        $m_h_ca->action .= "<strong>RCS espèces: </strong> " . $m_ca->rcs_especes . "\n";
        $m_h_ca->action .= "<strong>RCS CB: </strong> " . $m_ca->rcs_cb . "\n";
        $m_h_ca->action .= "<strong>RCSD chèque: </strong> " . $m_ca->rcsd_cheque . "\n";
        $m_h_ca->action .= "<strong>RCSD espèces: </strong> " . $m_ca->rcsd_especes . "\n";
        $m_h_ca->action .= "<strong>RCSD CB: </strong> " . $m_ca->rcsd_cb . "\n";
        $m_h_ca->action .= "<strong>RAC part patient: </strong> " . $m_ca->rac_part_patient . "\n";
        $m_h_ca->action .= "<strong>RAC chèque: </strong> " . $m_ca->rac_cheque . "\n";
        $m_h_ca->action .= "<strong>RAC espèces: </strong> " . $m_ca->rac_especes . "\n";
        $m_h_ca->action .= "<strong>RAC CB: </strong> " . $m_ca->rac_cb . "\n";
        $m_h_ca->action .= "<strong>Commentaire: </strong> " . $m_ca->commentaire . "\n";
        $m_h_ca->action .= "<strong>Date: </strong> " . Carbon::parse($m_ca->created_at)->format('d-m-Y') . "\n";
        $m_h_ca->save();
        DB::delete('DELETE FROM ca_actes_reglements WHERE id = ?', [$id_ca]);
        return back();
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
        $data['dossier_statuss'] = DossierStatus::orderBy('ordre', 'desc')->where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('ca/liste-ca')->with($data);
    }
    public function showNouveauCa()
    {
        $data['status'] = DossierStatus::orderBy('ordre', 'desc')->where('is_deleted', 0)
            ->where('status','!=', '')
            ->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)
            ->where('praticien', '!=', '')
            ->get();
        return view('ca/nouveau/nouveau-ca')->with($data);
    }
}
