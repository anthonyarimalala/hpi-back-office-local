<?php

namespace App\Http\Controllers\Dossier\Devis;

use App\Http\Controllers\Controller;
use App\Models\devis\Devis;
use App\Models\devis\DevisAccordPec;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\devis\DevisEtat;
use App\Models\devis\DevisReglement;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\dossier\L_DossierMutuelle;
use App\Models\hist\H_Devis;
use App\Models\praticien\Praticien;
use App\Models\views\V_Devis;
use App\Models\views\V_H_Devis;
use App\Models\views\V_PatientDossier;
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


            //print($date_envoi_mail);

            $m_devis = Devis::updateDevis($m_h_devis, $id_devis, $devis_signe, $observation, $id_devis_etat);
            DevisAccordPec::createOrUpdateDevisAccordPecs($m_h_devis, $id_devis, $date_envoi_pec, $date_fin_validite_pec, $part_mutuelle, $part_rac);
            DevisReglement::createDevisReglement($m_h_devis, $id_devis, $date_paiement_cb_ou_esp, $date_depot_chq_pec, $date_depot_chq_part_mut, $date_depot_chq_rac);
            DevisAppelsEtMail::createDevisAppelsEtMail($m_h_devis, $id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel, $note_2eme_appel, $date_3eme_appel, $note_3eme_appel, $date_envoi_mail);
            $m_h_devis->save();
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
        $data['praticiens'] = Praticien::where('is_deleted',0)->get();
        return view('dossier/devis/detail/modifier/devis-modifier-2')->with($data);
    }


    public function getDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['hists'] = V_H_Devis::where('id_devis', $id_devis)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
        return view('dossier/devis/detail/devis')->with($data);
    }
    public function creerDevis(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'date' => 'required|date',
            'montant' => 'required|numeric|min:0.01',
            'devis_signe' => 'required|in:oui,non',
            'praticien' => 'required|exists:praticiens,praticien',  // Assurez-vous que la table 'praticiens' et la colonne 'praticien' existent
            'observation' => 'nullable|string|max:500',  // 'nullable' permet de laisser ce champ vide
        ]);

        // Récupération des données validées
        $dossier = $request->input('dossier');
        $status = $request->input('status');
        $mutuelle = $request->input('mutuelle');
        $date = $validated['date'];
        $montant = $validated['montant'];
        $devis_signe = $validated['devis_signe'];
        $praticien = $validated['praticien'];
        $observation = $validated['observation'];

        try {
            // Création du devis
            Devis::createDevis($dossier, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation);
            return redirect()->to($dossier.'/liste-devis')->with('success', 'Le devis a été ajouté avec succès.');
        } catch (\Exception $e) {
            // print($e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }
    }

    public function nouveauDevis($dossier){
        $data['dossier'] = Dossier::where('dossier', $dossier)->first();
        $data['statuss'] = DossierStatus::where('is_deleted', 0)->get();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('dossier/devis/nouveau-devis')->with($data);
    }
    public function getListeDevis($dossier){
        $data['deviss'] = V_Devis::where('dossier', $dossier)->orderBy('date', 'desc')->get();
        $data['dossier'] = Dossier::where('dossier', $dossier)->first();
        return view('dossier/devis/liste-devis-dossier')->with($data);
    }

    /*
    public function getAllListeDevis(Request $request){
        $query = V_Devis::query();
        $data['deviss'] = $query->orderBy('date', 'desc')->paginate(20);
        //print($query->toSql());
        $data['praticiens'] = Praticien::all();
        return view('devis/liste-devis-2')->with($data);
    }
    */


    public function getAllListeDevis(Request $request){
        $date_devis_debut = $request->input('date_devis_debut');
        $date_devis_fin = $request->input('date_devis_fin');
        $montant_min = $request->input('montant_min');
        $montant_max = $request->input('montant_max');
        $devis_signe = $request->input('devis_signe');
        $praticiens = $request->input('praticiens');

        // Création de la requête de base
        $query = V_Devis::query(); // Crée une requête de base

        // Applique les filtres de date
        if ($date_devis_debut) {
            $query->where('date', '>=', $date_devis_debut);
        }
        if ($date_devis_fin) {
            $query->where('date', '<=', $date_devis_fin);
        }
        if ($montant_min) {
            $query->where('montant', '>=', $montant_min);
        }
        if ($montant_max) {
            $query->where('montant', '<=', $montant_max);
        }
        if ($devis_signe != '' || $devis_signe) {
            $query->where('devis_signe', $devis_signe);
        }
        if ($praticiens && count($praticiens) > 0) {
            $query->whereIn('praticien', $praticiens); // Exclut les praticiens présents dans le tableau
        }

        // Exécution de la requête avec pagination (20 éléments par page)
        $data['deviss'] = $query->orderBy('date', 'desc')->paginate(20)->appends([
            'date_devis_debut' => $date_devis_debut,
            'date_devis_fin' => $date_devis_fin,
            'montant_min' => $montant_min,
            'montant_max' => $montant_max,
            'devis_signe' => $devis_signe,
            'praticiens' => $praticiens
        ]);
        $data['praticiens'] = Praticien::all();

        return view('devis/liste-devis-2')->with($data)
            ->with([
            'inp_date_devis_debut' => $date_devis_debut,
            'inp_date_devis_fin' => $date_devis_fin,
            'inp_montant_min' => $montant_min,
            'inp_montant_max' => $montant_max,
            'inp_devis_signe' => $devis_signe,
            'inp_praticiens' => $praticiens
        ]);
    }

}
