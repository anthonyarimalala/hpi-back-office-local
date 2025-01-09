<?php

namespace App\Http\Controllers\Dossier\Devis;

use App\Http\Controllers\Controller;
use App\Models\devis\Devis;
use App\Models\devis\DevisAccordPec;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\devis\DevisReglement;
use App\Models\praticien\Praticien;
use App\Models\views\V_Devis;
use App\Models\views\V_PatientDossier;
use Illuminate\Http\Request;

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


            //print($date_envoi_mail);

            Devis::updateDevis($id_devis, $devis_signe, $observation);
            DevisAccordPec::createOrUpdateDevisAccordPecs($id_devis, $date_envoi_pec, $date_fin_validite_pec, $part_mutuelle, $part_rac);
            DevisReglement::createDevisReglement($id_devis, $date_paiement_cb_ou_esp, $date_depot_chq_pec, $date_depot_chq_part_mut, $date_depot_chq_rac);
            DevisAppelsEtMail::createDevisAppelsEtMail($id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel, $note_2eme_appel, $date_3eme_appel, $note_3eme_appel, $date_envoi_mail);

            return back()->with('success', 'Le devis a été modifié avec succès.');
        } catch (\Exception $e) {
            // return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
            print ($e->getMessage());
        }
    }

    public function showModifierDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier',$dossier)
            ->where('id_devis', $id_devis)
            ->first();
        $data['praticiens'] = Praticien::where('is_deleted',0)->get();
        return view('dossier/devis/detail/modifier/devis-prothese-chq-modifier')->with($data);
    }

    public function getDevis($dossier, $id_devis){
        $data['v_devis'] = V_Devis::where('dossier', $dossier)
            ->where('id_devis', $id_devis)
            ->first();
        return view('dossier/devis/detail/devis-prothese-chq')->with($data);
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
        $date = $validated['date'];
        $montant = $validated['montant'];
        $devis_signe = $validated['devis_signe'];
        $praticien = $validated['praticien'];
        $observation = $validated['observation'];

        try {
            // Création du devis
            Devis::createDevis($dossier, $date, $montant, $devis_signe, $praticien, $observation);
            return redirect()->to($dossier.'/liste-devis')->with('success', 'Le devis a été ajouté avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la modification du devis : ' . $e->getMessage());
        }
    }

    public function nouveauDevis($dossier){
        $data['dossier'] = V_PatientDossier::where('dossier', $dossier)->first();
        $data['praticiens'] = Praticien::where('is_deleted', 0)->get();
        return view('dossier/devis/nouveau-devis')->with($data);
    }
    public function getListeDevis($dossier){
        $data['deviss'] = Devis::where('dossier', $dossier)->orderBy('date', 'desc')->get();
        $data['dossier'] = V_PatientDossier::where('dossier', $dossier)->first();
        return view('dossier/devis/liste-devis-dossier')->with($data);
    }
    public function getAllListeDevis(){
        $data['deviss'] = V_Devis::orderBy('date', 'desc')->get();
        return view('devis/liste-devis')->with($data);
    }
}
