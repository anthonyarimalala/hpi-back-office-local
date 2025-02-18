<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\CaImport;
use App\Imports\DevisImport;
use App\Models\ca\CaActesReglement;
use App\Models\devis\cheque\InfoCheque;
use App\Models\devis\Devis;
use App\Models\devis\DevisAccordPec;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\devis\DevisEtat;
use App\Models\devis\DevisReglement;
use App\Models\devis\prothese\ProtheseEmpreinte;
use App\Models\devis\prothese\ProtheseRetourLabo;
use App\Models\devis\prothese\ProtheseTravaux;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use App\Models\dossier\Dossier;
use App\Models\import\ImportCa;
use App\Models\import\ImportDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    //
    public function importerCa(Request $request)
    {
        $request->validate([
           'caFile' => 'required|file|mimes:xlsx,xls',
        ]);
        $file = $request->file('caFile');
        DB::delete('DELETE FROM import_ca_actes_reglements');
        Excel::import(new CaImport, $file);

        $m_import_cas = ImportCa::all();
        foreach ($m_import_cas as $mic){

            $m_dossier = Dossier::firstOrNew(['dossier' => $mic->dossier]);
            $m_dossier->nom = $mic->nom_patient;
            $m_dossier->save();

            $m_ca = new CaActesReglement();
            $m_ca->date_derniere_modif = $mic->date_derniere_modif;
            $m_ca->dossier = $mic->dossier;
            $m_ca->statut = $mic->status;
            $m_ca->mutuelle = $mic->mutuelle;
            $m_ca->praticien = $mic->praticien;
            $m_ca->nom_acte = $mic->nom_acte;
            $m_ca->cotation = $mic->cotation;
            $m_ca->controle_securisation = $mic->controle_securisation;
            $m_ca->ro_part_secu = $mic->ro_part_secu;
            $m_ca->ro_virement_recu = $mic->ro_virement_recu;
            $m_ca->ro_indus_paye = $mic->ro_indus_paye;
            $m_ca->ro_indus_en_attente = $mic->ro_indus_en_attente;
            $m_ca->ro_indus_irrecouvrable = $mic->ro_indus_irrecouvrable;
            $m_ca->part_mutuelle = $mic->part_mutuelle;
            $m_ca->rcs_virement = $mic->rcs_virement;
            $m_ca->rcs_especes = $mic->rcs_especes;
            $m_ca->rcs_cb = $mic->rcs_cb;
            $m_ca->rcsd_cheque = $mic->rcsd_cheque;
            $m_ca->rcsd_especes = $mic->rcsd_especes;
            $m_ca->rcsd_cb = $mic->rcsd_cb;
            $m_ca->rac_part_patient = $mic->rac_part_patient;
            $m_ca->rac_cheque = $mic->rac_cheque;
            $m_ca->rac_especes = $mic->rac_especes;
            $m_ca->rac_cb = $mic->rac_cb;
            $m_ca->commentaire = $mic->commentaire;
            $m_ca->save();

        }
        return back()->with('success', 'Fichier importé avec succès');
    }
    public function importerDevis(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'devisFile' => 'required|file|mimes:xlsx,xls',
        ]);
        $file = $request->file('devisFile');

        DB::delete('DELETE FROM import_devis');

        // step-1: importation des données
        // Importer le fichier avec la classe d'import
        Excel::import(new DevisImport($file), $file);

        // step-2: mise à jour et insertion des données, celà peut prendre un certain moment
        $m_import_deviss = ImportDevis::all();
        foreach ($m_import_deviss as $mid){

            $m_protheseTravauxStatus = ProtheseTravauxStatus::where('travaux_status', $mid->pose_statut)->first();
            $m_devis_etats = DevisEtat::where('couleur', $mid->couleur)->get();
            $m_dossier = Dossier::firstOrNew(['dossier' => $mid->dossier]);
            $m_dossier->nom = $mid->nom;
            $m_dossier->status = $mid->status;
            $m_dossier->mutuelle = $mid->mutuelle;
            $m_dossier->save();

            $m_devis = Devis::firstOrNew(['dossier' => $mid->dossier, 'date' => $mid->date]);
            $m_devis->status = $mid->status;
            $m_devis->mutuelle = $mid->mutuelle;
            $m_devis->date = $mid->date;
            $m_devis->montant = $mid->montant;
            $m_devis->devis_signe = $mid->devis_signe;
            $m_devis->praticien = $mid->praticien;
            $m_devis->observation = $mid->devis_observation;
            foreach ($m_devis_etats as $m_devis_etat){$m_devis->id_devis_etat = $m_devis_etat->id;}
            if($m_devis->id_devis_etat == null) $m_devis->id_devis_etat = 1;
            $m_devis->save();
            $m_devis_accord_pec = DevisAccordPec::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_accord_pec->date_envoi_pec = $mid->date_envoi_pec;
            $m_devis_accord_pec->date_fin_validite_pec = $mid->date_fin_validite_pec;
            $m_devis_accord_pec->part_mutuelle = $mid->part_mutuelle;
            $m_devis_accord_pec->part_rac = $mid->part_rac;
            $m_devis_accord_pec->save();
            $m_devis_appels_et_mails = DevisAppelsEtMail::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_appels_et_mails->date_1er_appel = $mid->date_1er_appel;
            $m_devis_appels_et_mails->note_1er_appel = $mid->note_1er_appel;
            $m_devis_appels_et_mails->date_2eme_appel = $mid->date_2eme_appel;
            $m_devis_appels_et_mails->note_2eme_appel = $mid->note_2eme_appel;
            $m_devis_appels_et_mails->date_3eme_appel = $mid->date_3eme_appel;
            $m_devis_appels_et_mails->note_3eme_appel = $mid->note_3eme_appel;
            $m_devis_appels_et_mails->date_envoi_mail = $mid->date_envoi_mail;
            $m_devis_appels_et_mails->save();
            $m_devis_reglements = DevisReglement::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_reglements->date_paiement_cb_ou_esp = $mid->date_paiement_cb_ou_esp;
            $m_devis_reglements->date_depot_chq_pec = $mid->date_depot_chq_pec;
            $m_devis_reglements->date_depot_chq_part_mut = $mid->date_depot_chq_part_mut;
            $m_devis_reglements->date_depot_chq_rac = $mid->date_depot_chq_rac;
            $m_devis_reglements->save();
            $m_prothese_empreintes = ProtheseEmpreinte::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_empreintes->laboratoire = $mid->laboratoire;
            $m_prothese_empreintes->date_empreinte = $mid->date_empreinte;
            $m_prothese_empreintes->date_envoi_labo = $mid->date_envoi_labo;
            $m_prothese_empreintes->travail_demande = $mid->travail_demande;
            $m_prothese_empreintes->numero_dent = $mid->numero_dent;
            $m_prothese_empreintes->observations = $mid->empreinte_observation;
            $m_prothese_empreintes->save();
            $m_prothese_retour_labos = ProtheseRetourLabo::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_retour_labos->date_livraison = $mid->date_livraison;
            $m_prothese_retour_labos->numero_suivi = $mid->numero_suivi;
            $m_prothese_retour_labos->numero_facture_labo = $mid->numero_facture_labo;
            $m_prothese_retour_labos->save();
            $m_prothese_travaux = ProtheseTravaux::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_travaux->date_pose_prevue = $mid->date_pose_prevue;
/*-------*/ if ($m_protheseTravauxStatus) $m_prothese_travaux->id_pose_statut = $m_protheseTravauxStatus->id;
            $m_prothese_travaux->date_pose_reel = $mid->date_pose_reel;
            $m_prothese_travaux->organisme_payeur = $mid->organisme_payeur;
            $m_prothese_travaux->montant_encaisse = $mid->montant_encaisse;
            $m_prothese_travaux->date_controle_paiement = $mid->date_controle_paiement;
            $m_prothese_travaux->save();
            $m_info_cheques = InfoCheque::firstOrNew(['id_devis' => $m_devis->id]);
            $m_info_cheques->numero_cheque = $mid->numero_cheque;
            $m_info_cheques->montant_cheque = $mid->montant_cheque;
            $m_info_cheques->nom_document = $mid->nom_document;
            $m_info_cheques->date_encaissement_cheque = $mid->date_encaissement_cheque;
            $m_info_cheques->date_1er_acte = $mid->date_1er_acte;
            $m_info_cheques->nature_cheque = $mid->nature_cheque;
            $m_info_cheques->travaux_sur_devis = $mid->travaux_sur_devis;
            $m_info_cheques->situation_cheque = $mid->situation_cheque;
            $m_info_cheques->observation = $mid->cheque_observation;
            $m_info_cheques->save();
        }
        return back()->with('success', 'Fichier importé avec succès!');
    }
    public function showImports(){
        return view('imports/imports');
    }
}
