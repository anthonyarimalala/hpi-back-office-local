<?php

namespace App\Http\Controllers\Dossier\Devis;

use App\Http\Controllers\Controller;
use App\Models\devis\cheque\InfoChequeNatureCheque;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use App\Models\devis\Devis;
use App\Models\devis\DevisAccordPec;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\devis\DevisEtat;
use App\Models\devis\DevisReglement;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\hist\H_Devis;
use App\Models\praticien\Praticien;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    //
    public function modifierDevis(Request $request)
    {
        try {
            // table: devis
            $id_devis = $request->input('id_devis');
            $devis_signe = $request->input('devis_signe');
            $observation = $request->input('observation');
            $id_devis_etat = $request->input('id_devis_etat');

            // table: devis_accord_pecs
            $date_envoi_pec = $request->input('date_envoi_pec');
            $date_fin_validite_pec = $request->input('date_fin_validite_pec');
            $part_mutuelle = $request->input('part_mutuelle');
            $part_rac = $request->input('part_rac');

            // table: devis_reglements
            $date_paiement_cb_ou_esp = $request->input('date_paiement_cb_ou_esp');
            $date_depot_chq_pec = $request->input('date_depot_chq_pec');
            $date_depot_chq_part_mut = $request->input('date_depot_chq_part_mut');
            $date_depot_chq_rac = $request->input('date_depot_chq_rac');

            // table: devis_appels_et_mails
            $date_1er_appel = $request->input('date_1er_appel');
            $note_1er_appel = $request->input('note_1er_appel');
            $date_2eme_appel = $request->input('date_2eme_appel');
            $note_2eme_appel = $request->input('note_2eme_appel');
            $date_3eme_appel = $request->input('date_3eme_appel');
            $note_3eme_appel = $request->input('note_3eme_appel');
            $date_envoi_mail = $request->input('date_envoi_mail');

            $m_h_devis = new H_Devis();
            $m_h_devis->code_u = Auth::user()->code_u;
            $m_h_devis->id_devis = $id_devis;

            // Obtenir tous les clés primaires pour éviter de faire trop de requetes vers la base de donnée
            $m_devis_etatsS = DevisEtat::all();

            $m_devis_ancien = Devis::find($id_devis);
            $m_devis_nouveau = clone $m_devis_ancien;
            $m_devis_nouveau->devis_signe = $devis_signe;
            $m_devis_nouveau->observation = $observation;
            $m_devis_nouveau->id_devis_etat = $id_devis_etat;

            $m_devis = Devis::updateDevis($m_h_devis, $m_devis_etatsS, $m_devis_ancien, $m_devis_nouveau, $withChange);
            DevisAccordPec::createOrUpdateDevisAccordPecs($m_h_devis, $id_devis, $date_envoi_pec, $date_fin_validite_pec, $part_mutuelle, $part_rac, $withChange);
            DevisReglement::createDevisReglement($m_h_devis, $id_devis, $date_paiement_cb_ou_esp, $date_depot_chq_pec, $date_depot_chq_part_mut, $date_depot_chq_rac, $withChange);
            DevisAppelsEtMail::createDevisAppelsEtMail($m_h_devis, $id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel, $note_2eme_appel, $date_3eme_appel, $note_3eme_appel, $date_envoi_mail, $withChange);

            // mettre le numero de dossier dans l'historique: dénormalisation
            $m_h_devis->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
            $m_h_devis->dossier = $m_devis->dossier;
            if ($withChange) $m_h_devis->save();
            return redirect()->route('devis.detail', [
                'dossier' => $m_devis->dossier,    // Remplacez par la valeur réelle de $dossier
                'id_devis' => $id_devis      // Remplacez par la valeur réelle de $id_devis
            ])->with('success', 'Le devis a été modifié avec succès.');

        } catch (\Exception $e) {
            // return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
            print ($e->getMessage());
        }
    }

    public function showModifierDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier',$dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['etat_devis'] = DevisEtat::all();
        return view('dossier/devis/detail/modifier/devis-modifier-2')->with($data);
    }


    public function getDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['hists'] = H_Devis::where('id_devis', $id_devis)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
        return view('dossier/devis/detail/devis')->with($data);
    }

    public function creerDevisSansDossier(Request $request){
        $validated = $request->validate([
            'doss' => 'required',
            'status' => 'required',
            'montant' => 'required|numeric|min:0.01',
            'devis_signe' => 'required|in:oui,non',
            'praticien' => 'required|exists:praticiens,praticien',  // Assurez-vous que la table 'praticiens' et la colonne 'praticien' existent
            'observation' => 'nullable|string',  // 'nullable' permet de laisser ce champ vide
        ]);
        $dossier = $validated['doss'];
        $nom = $request->input('nom');
        $status = $validated['status'];
        $date = $request->input('date');
        if (!$date || $date=='') $date = Carbon::parse()->format('Y-m-d');
        $mutuelle = $request->input('mutuelle');
        $montant = $validated['montant'];
        $devis_signe = $validated['devis_signe'];
        $praticien = $validated['praticien'];
        $observation = $validated['observation'];

        echo ($nom);
        $id_devis = Devis::createDevisSansDossier($dossier, $nom, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation);
        return redirect()->to($dossier.'/devis/'.$id_devis.'/detail');
    }
    public function creerDevis(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'devis_signe' => 'required|in:oui,non',
            'praticien' => 'required|exists:praticiens,praticien',  // Assurez-vous que la table 'praticiens' et la colonne 'praticien' existent
            'observation' => 'nullable|string',  // 'nullable' permet de laisser ce champ vide
        ]);

        // Récupération des données validées
        $dossier = $request->input('dossier');
        $status = $request->input('status');
        $mutuelle = $request->input('mutuelle');
        $date = $request->input('date');
        if (!$date || $date=='') $date = Carbon::parse()->format('Y-m-d');
        $montant = $validated['montant'];
        $devis_signe = $validated['devis_signe'];
        $praticien = $validated['praticien'];
        $observation = $validated['observation'];

        try {
            // Création du devis
            Devis::createDevis($dossier, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation);
            return redirect()->to($dossier.'/details')->with('success', 'Le devis a été ajouté avec succès.');
        } catch (\Exception $e) {
            // print($e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }
    }

    public function nouveauDevis($dossier){
        $data['dossier'] = Dossier::where('dossier', $dossier)->first();
        $data['statuss'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->where('praticien', '!=','')->get();
        return view('dossier/devis/nouveau-devis')->with($data);
    }
    public function showNouveauDevis(){
        $data['statuss'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('devis/nouveau/nouveau-devis')->with($data);
    }

    public function reinitializeFilterListeDevis(){
        session()->forget('devis_filters');
        $m_v_deviss = V_Devis::orderBy('date', 'desc')
            ->where('is_deleted', 0)
            ->paginate(20);
        session()->put('deviss', $m_v_deviss);
        return back();
    }
    public function getFilterListeDevis(Request $request){
        $filters = [
            'id_devis_etats' => $request->input('id_devis_etats'),
            'date_devis_debut' => $request->input('date_devis_debut'),
            'date_devis_fin' => $request->input('date_devis_fin'),
            'montant_min' => $request->input('montant_min'),
            'montant_max' => $request->input('montant_max'),
            'praticiens' => $request->input('praticiens'),
            'devis_signe' => $request->input('devis_signe'),
            'date_envoi_pec_debut' => $request->input('date_envoi_pec_debut'),
            'date_envoi_pec_fin' => $request->input('date_envoi_pec_fin'),
            'date_envoi_pec_null' => $request->input('date_envoi_pec_null'),
            'date_fin_validite_pec_debut' => $request->input('date_fin_validite_pec_debut'),
            'date_fin_validite_pec_fin' => $request->input('date_fin_validite_pec_fin'),
            'date_fin_validite_pec_null' => $request->input('date_fin_validite_pec_null'),
            'part_mutuelle_min' => $request->input('part_mutuelle_min'),
            'part_mutuelle_max' => $request->input('part_mutuelle_max'),
            'part_mutuelle_null' => $request->input('part_mutuelle_max'),
            'part_rac_min' => $request->input('part_rac_min'),
            'part_rac_max' => $request->input('part_rac_max'),
            'part_rac_null' => $request->input('part_rac_null'),
            'date_1er_appel_debut' => $request->input('date_1er_appel_debut'),
            'date_1er_appel_fin' => $request->input('date_1er_appel_fin'),
            'date_1er_appel_null' => $request->input('date_1er_appel_null'),
            'date_2eme_appel_debut' => $request->input('date_2eme_appel_debut'),
            'date_2eme_appel_fin' => $request->input('date_2eme_appel_fin'),
            'date_2eme_appel_null' => $request->input('date_2eme_appel_null'),
            'date_3eme_appel_debut' => $request->input('date_3eme_appel_debut'),
            'date_3eme_appel_fin' => $request->input('date_3eme_appel_fin'),
            'date_3eme_appel_null' => $request->input('date_3eme_appel_null'),
            'date_envoi_mail_debut' => $request->input('date_envoi_mail_debut'),
            'date_envoi_mail_fin' => $request->input('date_envoi_mail_fin'),
            'date_envoi_mail_null' => $request->input('date_envoi_mail_null'),
            'date_empreinte_debut' => $request->input('date_empreinte_debut'),
            'date_empreinte_fin' => $request->input('date_empreinte_fin'),
            'date_empreinte_null' => $request->input('date_empreinte_null'),
            'date_envoi_labo_debut' => $request->input('date_envoi_labo_debut'),
            'date_envoi_labo_fin' => $request->input('date_envoi_labo_fin'),
            'date_envoi_labo_null' => $request->input('date_envoi_labo_null'),
            'date_livraison_debut' => $request->input('date_livraison_debut'),
            'date_livraison_fin' => $request->input('date_livraison_fin'),
            'date_livraison_null' => $request->input('date_livraison_null'),
            'numero_suivi' => $request->input('numero_suivi'),
            'numero_suivi_null' => $request->input('numero_suivi_null'),
            'numero_facture_labo' => $request->input('numero_facture_labo'),
            'numero_facture_labo_null' => $request->input('numero_facture_null'),
            'date_pose_prevue_debut' => $request->input('date_pose_prevue_debut'),
            'date_pose_prevue_fin' => $request->input('date_pose_prevue_fin'),
            'date_pose_prevue_null' => $request->input('date_pose_prevue_null'),
            'id_pose_statuts' => $request->input('id_pose_statuts'),
            'date_pose_reel_debut' => $request->input('date_pose_reel_debut'),
            'date_pose_reel_fin' => $request->input('date_pose_reel_fin'),
            'date_pose_reel_null' => $request->input('date_pose_reel_null'),
            'montant_encaisse_min' => $request->input('montant_encaisse_min'),
            'montant_encaisse_max' => $request->input('montant_encaisse_max'),
            'montant_encaisse_null' => $request->input('montant_encaisse_null'),
            'date_controle_paiement_debut' => $request->input('date_date_controle_paiement_debut'),
            'date_controle_paiement_fin' => $request->input('date_date_controle_paiement_fin'),
            'date_controle_paiement_null' => $request->input('date_controle_paiement_null'),
            'numero_cheque' => $request->input('numero_cheque'),
            'numero_cheque_null' => $request->input('numero_cheque_null'),
            'montant_cheque_min' => $request->input('montant_cheque_min'),
            'montant_cheque_max' => $request->input('montant_cheque_max'),
            'montant_cheque_null' => $request->input('montant_cheque_null'),
            'date_encaissement_cheque_debut' => $request->input('date_encaissement_cheque_debut'),
            'date_encaissement_cheque_fin' => $request->input('date_encaissement_cheque_fin'),
            'date_encaissement_cheque_null' => $request->input('date_encaissement_cheque_fin'),
            'date_1er_acte_debut' => $request->input('date_1er_acte_debut'),
            'date_1er_acte_fin' => $request->input('date_1er_acte_fin'),
            'date_1er_acte_null' => $request->input('date_1er_acte_null'),
            'nature_cheques' => $request->input('nature_cheques'),
            'travaux_sur_devis' => $request->input('travaux_sur_devis'),
            'situation_cheques' => $request->input('situation_cheques'),
            'stringFilters' => [],
        ];

        session()->put('devis_filters', $filters);
        return redirect('liste/devis');
    }

    public function getAllListeDevis(Request $request){
        $filters = session()->get('devis_filters', []);
        $m_v_devis = new V_Devis();
        $query = $m_v_devis->query(); // Crée une requête de base
        if ($filters)
            $m_v_devis->scopeFiltrer($query, $filters);
        $m_v_deviss = $query->orderBy('date', 'desc')
            ->where('is_deleted', 0)
            ->paginate(20);
        $data['deviss'] = $m_v_deviss;
        $data['praticiens'] = Praticien::all();
        $data['devis_etats'] = DevisEtat::all();
        $data['pose_status'] = ProtheseTravauxStatus::all();
        $data['nature_cheques'] = InfoChequeNatureCheque::all();
        $data['travaux_sur_devis'] = InfoChequeTravauxDevis::all();
        $data['situation_cheques'] = InfoChequeSituationCheque::all();
        $data['filters'] = $filters;

        return view('devis/liste-devis-2')->with($data);
    }

}
