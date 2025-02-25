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
use App\Models\error\ErrorImport;
use App\Models\import\ImportCa;
use App\Models\import\ImportDevis;
use App\Models\praticien\Praticien;
use App\Models\views\V_Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportsController extends Controller
{
    //
    public function importerCa(Request $request)
    {

        $request->validate([
           'caFile' => 'required|file|mimes:xlsx,xls',
            'action' => 'required',
        ]);
        $action = $request->input('action');
        $file = $request->file('caFile');
        $m_import_ca = new ImportCa();
        DB::delete('DELETE FROM import_ca_actes_reglements');
        DB::delete('DELETE FROM errors_imports');
        Excel::import(new CaImport, $file);
        $m_import_cas = ImportCa::all();
        $withErrors = false;
        foreach ($m_import_cas as $mic){

            $m_dossier = Dossier::firstOrNew(['dossier' => $mic->dossier]);
            $m_dossier->nom = $mic->nom_patient;
            $m_dossier->save();
            $m_praticien = Praticien::firstOrNew(['praticien' => trim($mic->praticien)]);
            $m_praticien->is_deleted = 0;
            if (!$m_praticien) $m_praticien->save();
            // mise en place des erreurs
            $m_error_import = new ErrorImport();
            $m_error_import->type = 2; // ne change pas
            $m_error_import->date = Date::excelToDateTimeObject((float) trim($mic->date_derniere_modif))->format('Y-m-d');
            $m_error_import->dossier = $mic->dossier;
            $m_error_import->error_message = '';

            if ($action == 'nouveau')
                $m_ca = new CaActesReglement();
            else
                $m_ca = CaActesReglement::where('dossier', $mic->dossier)->where('date_derniere_modif', $m_import_ca->makeDate($mic->date_derniere_modif))->first();
            if ($m_ca){
            // Date dernière modif
                try { $m_ca->date_derniere_modif = $mic->makeDateOrError($mic->date_derniere_modif); }
                catch (Exception $e) {
                    $m_ca->date_derniere_modif = null;
                    $m_error_import->error_message .= 'Date non conforme, ';
                    $m_error_import->description .= "<strong>Date de dernière modif: </strong>".$mic->date_derniere_modif."\n";
                }
            // dossier
                $m_ca->dossier = trim($mic->dossier);
            // status
                $m_ca->statut = trim($mic->status);
            // mutuelle
                $m_ca->mutuelle = trim($mic->mutuelle);
            // praticien
                $m_ca->praticien = trim($mic->praticien);
            // nom_acte
                $m_ca->nom_acte = trim($mic->nom_acte);
            // cotation
                if($mic->cotation && $mic->cotation != ''){
                    try {
                        $m_ca->cotation = $mic->makeNumericOrError($mic->cotation);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Cotation non conforme, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // controle_securisation
                $m_ca->controle_securisation = trim($mic->controle_securisation);
            // ro_part_secu
                if($mic->ro_part_secu && $mic->ro_part_secu != ''){
                    try {
                        $m_ca->ro_part_secu = $mic->makeNumericOrError($mic->ro_part_secu);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RO - Part Sécu non conforme, ';
                        $m_error_import->description .= "<strong>ro_part_secu: </strong>".$mic->ro_part_secu."\n";
                    }
                }

            // ro_virement_recu
                if($mic->ro_virement_recu && $mic->ro_virement_recu != ''){
                    try {
                        $m_ca->ro_virement_recu = $mic->makeNumericOrError($mic->ro_virement_recu);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RO- Virement reçu, ';
                        $m_error_import->description .= "<strong>ro_virement_recu: </strong>".$mic->ro_virement_recu."\n";
                    }
                }

                // ro_indus_paye
                if($mic->ro_indus_paye && $mic->ro_indus_paye != ''){
                    try {
                        $m_ca->ro_indus_paye = $mic->makeNumericOrError($mic->ro_indus_paye);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RO - Indus payé , ';
                        $m_error_import->description .= "<strong>ro_indus_paye: </strong>".$mic->ro_indus_paye."\n";
                    }
                }

            // ro_indus_en_attente
                if($mic->ro_indus_en_attente && $mic->ro_indus_en_attente != ''){
                    try {
                        $m_ca->ro_indus_en_attente = $mic->makeNumericOrError($mic->ro_indus_en_attente);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RO - Indus en attente, ';
                        $m_error_import->description .= "<strong>ro_indus_en_attente: </strong>".$mic->ro_indus_en_attente."\n";
                    }
                }

            // ro_indus_irrecouvrable
                if($mic->ro_indus_irrecouvrable && $mic->ro_indus_irrecouvrable != ''){
                    try {
                        $m_ca->ro_indus_irrecouvrable = $mic->makeNumericOrError($mic->ro_indus_irrecouvrable);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RO - Indus irrecouvrable, ';
                        $m_error_import->description .= "<strong>ro_indus_irrecouvrable: </strong>".$mic->ro_indus_irrecouvrable."\n";
                    }
                }

            // part_mutuelle
                if($mic->part_mutuelle && $mic->part_mutuelle != ''){
                    try {
                        $m_ca->part_mutuelle = $mic->makeNumericOrError($mic->part_mutuelle);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Part mutuelle, ';
                        $m_error_import->description .= "<strong>part_mutuelle: </strong>".$mic->part_mutuelle."\n";
                    }
                }
            // rcs_virement
                if($mic->rcs_virement && $mic->rcs_virement != ''){
                    try {
                        $m_ca->rcs_virement = $mic->makeNumericOrError($mic->rcs_virement);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RC SOINS - Virement, ';
                        $m_error_import->description .= "<strong>rcs_virement: </strong>".$mic->rcs_virement."\n";
                    }
                }
            // rcs_especes
                if($mic->rcs_especes && $mic->rcs_especes != ''){
                    try {
                        $m_ca->rcs_especes = $mic->makeNumericOrError($mic->rcs_especes);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RC SOINS - Espèces, ';
                        $m_error_import->description .= "<strong>rcs_especes: </strong>".$mic->rcs_especes."\n";
                    }
                }
            // rcs_especes
                if($mic->rcs_cb && $mic->rcs_cb!=''){
                    try {
                        $m_ca->rcs_cb = $mic->makeNumericOrError($mic->rcs_cb);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RC SOINS - CB, ';
                        $m_error_import->description .= "<strong>rcs_especes: </strong>".$mic->rcs_cb."\n";
                    }
                }

            // rcs_cb
                if($mic->rcs_cb && $mic->rcs_cb != ''){
                    try {
                        $m_ca->rcs_cb = $mic->makeNumericOrError($mic->rcs_cb);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RAC - Part patient, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rcsd_cheque
                if($mic->rcsd_cheque && $mic->rcsd_cheque != ''){
                    try {
                        $m_ca->rcsd_cheque = $mic->makeNumericOrError($mic->rcsd_cheque);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RAC - Chèque, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rcsd_especes
                if($mic->rcsd_especes && $mic->rcsd_especes != ''){
                    try {
                        $m_ca->rcsd_especes = $mic->makeNumericOrError($mic->rcsd_especes);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RAC - Espèces, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rcsd_cb
                if($mic->rcsd_cb && $mic->rcsd_cb != ''){
                    try {
                        $m_ca->rcsd_cb = $mic->makeNumericOrError($mic->rcsd_cb);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'RAC - CB, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rac_part_patient
                if($mic->rac_part_patient && $mic->rac_part_patient != ''){
                    try {
                        $m_ca->rac_part_patient = $mic->makeNumericOrError($mic->rac_part_patient);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Cotation non conforme, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rac_cheque
                if($mic->rac_cheque && $mic->rac_cheque != ''){
                    try {
                        $m_ca->rac_cheque = $mic->makeNumericOrError($mic->rac_cheque);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Cotation non conforme, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rac_especes
                if($mic->rac_especes && $mic->rac_especes != ''){
                    try {
                        $m_ca->rac_especes = $mic->makeNumericOrError($mic->rac_especes);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Cotation non conforme, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
            // rac_cb
                if($mic->rac_cb && $mic->rac_cb != ''){
                    try {
                        $m_ca->rac_cb = $mic->makeNumericOrError($mic->rac_cb);
                    }
                    catch (Exception $e) {
                        $m_error_import->error_message .= 'Cotation non conforme, ';
                        $m_error_import->description .= "<strong>Cotation: </strong>".$mic->cotation."\n";
                    }
                }
                $m_ca->commentaire = trim($mic->commentaire);
                $m_ca->save();
            }
            else{
                $m_error_import->error_message .= 'Dossier "'.$mic->dossier.'" non trouvé.';
            }
            if ($m_error_import->error_message != ''){
                $m_error_import->save();
                $withErrors = true;
            }
        }
        if (!$withErrors)
            return back()->with('success', 'Fichier importé avec succès');
        else
            return back()->with('warning', 'Données importées mais contiennent des erreurs');
    }
    public function importerDevis(Request $request)
    {
        $imp_devis = new ImportDevis();
        // Validation du fichier
        $request->validate([
            'devisFile' => 'required|file|mimes:xlsx,xls',
        ]);
        $file = $request->file('devisFile');

        DB::delete('DELETE FROM import_devis');
        DB::delete('DELETE FROM errors_imports');

        // step-1: importation des données
        // Importer le fichier avec la classe d'import
        Excel::import(new DevisImport($file), $file);

        // step-2: mise à jour et insertion des données, celà peut prendre un certain moment
        $m_import_deviss = ImportDevis::all();
        foreach ($m_import_deviss as $mid){

            $m_protheseTravauxStatus = ProtheseTravauxStatus::where('travaux_status', trim($mid->pose_statut))->first();
            $m_devis_etats = DevisEtat::where('couleur', trim($mid->couleur))->get();
            $m_dossier = Dossier::firstOrNew(['dossier' => trim($mid->dossier)]);
            $m_dossier->nom = trim($mid->nom);
            $m_dossier->status = trim($mid->status);
            $m_dossier->mutuelle = trim($mid->mutuelle);
            try {
                $m_dossier->save();
                    }catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "INFO PATIENT";
                        $m_error_import->description .= "<strong>Patient: </strong>".$mid->nom."\n";
                        $m_error_import->description .= "<strong>Mutuelle: </strong>".$mid->mutuelle."\n";
                        $m_error_import->description .= "<strong>Patient C2S: </strong>".$mid->status."\n";
                        $m_error_import->save();
                    }
            $m_devis = Devis::firstOrNew(['dossier' => $mid->dossier, 'date' => $mid->date]);
            $m_devis->status = trim($mid->status);
            $m_devis->mutuelle = trim($mid->mutuelle);
            $m_devis->date = $imp_devis->makeDate($mid->date);
            if ($mid->montant && $mid->montant != '') $m_devis->montant = $mid->montant;
            $m_devis->devis_signe = $imp_devis->makeDevisSigne($mid->devis_signe) ;
            $m_devis->praticien = trim($mid->praticien);
            $m_devis->observation = $mid->devis_observation;
            foreach ($m_devis_etats as $m_devis_etat){$m_devis->id_devis_etat = $m_devis_etat->id;}
            if($m_devis->id_devis_etat == null) $m_devis->id_devis_etat = 1;
            try {
                $m_devis->save();
                    }catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "INFO DEVIS";
                        $m_error_import->description .= "<strong>Date: </strong>".$mid->date."\n";
                        $m_error_import->description .= "<strong>Montant: </strong>".$mid->montant."\n";
                        $m_error_import->description .= "<strong>Devis signé: </strong>".$mid->devis_signe."\n";
                        $m_error_import->description .= "<strong>Praticien: </strong>".$mid->praticien."\n";
                        $m_error_import->description .= "<strong>Observation: </strong>".$mid->devis_observation."\n";
                        $m_error_import->save();
                    }
            $m_devis_accord_pec = DevisAccordPec::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_accord_pec->date_envoi_pec = $imp_devis->makeDate($mid->date_envoi_pec);
            $m_devis_accord_pec->date_fin_validite_pec = $imp_devis->makeDate($mid->date_fin_validite_pec);
            if ($mid->part_mutuelle && $mid->part_mutuelle != '') $m_devis_accord_pec->part_mutuelle = $mid->part_mutuelle;
            if ($mid->part_rac && $mid->part_rac != '') $m_devis_accord_pec->part_rac = $mid->part_rac;
            try {
                $m_devis_accord_pec->save();
                    } catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "INFO ACCORD PEC";
                        $m_error_import->description .= "<strong>Date d'envoi PEC: </strong>".$mid->date_envoi_pec."\n";
                        $m_error_import->description .= "<strong>Date fin validité PEC: </strong>".$mid->date_fin_validite_pec."\n";
                        $m_error_import->description .= "<strong>Part mutuelle: </strong>".$mid->part_mutuelle."\n";
                        $m_error_import->description .= "<strong>Part RAC: </strong>".$mid->part_rac."\n";
                        $m_error_import->save();
                    }

            $m_devis_appels_et_mails = DevisAppelsEtMail::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_appels_et_mails->date_1er_appel = $imp_devis->makeDate($mid->date_1er_appel);
            $m_devis_appels_et_mails->note_1er_appel = $mid->note_1er_appel;
            $m_devis_appels_et_mails->date_2eme_appel = $imp_devis->makeDate($mid->date_2eme_appel);
            $m_devis_appels_et_mails->note_2eme_appel = $mid->note_2eme_appel;
            $m_devis_appels_et_mails->date_3eme_appel = $imp_devis->makeDate($mid->date_3eme_appel);
            $m_devis_appels_et_mails->note_3eme_appel = $mid->note_3eme_appel;
            $m_devis_appels_et_mails->date_envoi_mail = $imp_devis->makeDate($mid->date_envoi_mail);
            try {
                $m_devis_appels_et_mails->save();
                    } catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "APPELS & MAIL";
                        $m_error_import->description .= "<strong>Date 1er Appel: </strong>".$mid->date_1er_appel."\n";
                        $m_error_import->description .= "<strong>Note 1er Appel: </strong>".$mid->note_1er_appel."\n";
                        $m_error_import->description .= "<strong>Date 2ème Appel (2j ap. 1er app): </strong>".$mid->date_2eme_appel."\n";
                        $m_error_import->description .= "<strong>Note 2ème Appel: </strong>".$mid->note_2eme_appel."\n";
                        $m_error_import->description .= "<strong>Date 3ème Appel (3j ap. 2e app): </strong>".$mid->date_3eme_appel."\n";
                        $m_error_import->description .= "<strong>Note 3ème Appel: </strong>".$mid->note_3eme_appel."\n";
                        $m_error_import->description .= "<strong>Date envoi de mail (même j 3e app): </strong>".$mid->date_envoi_mail."\n";
                        $m_error_import->save();
                    }


            $m_devis_reglements = DevisReglement::firstOrNew(['id_devis' => $m_devis->id]);
            $m_devis_reglements->date_paiement_cb_ou_esp = $imp_devis->makeDate($mid->date_paiement_cb_ou_esp);
            $m_devis_reglements->date_depot_chq_pec = $imp_devis->makeDate($mid->date_depot_chq_pec);
            $m_devis_reglements->date_depot_chq_part_mut = $imp_devis->makeDate($mid->date_depot_chq_part_mut);
            $m_devis_reglements->date_depot_chq_rac = $imp_devis->makeDate($mid->date_depot_chq_rac);
            try {
                $m_devis_reglements->save();
                    }catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "APPELS & MAIL";
                        $m_error_import->description .= "<strong>Date paiement par CB ou Esp: </strong>".$mid->date_paiement_cb_ou_esp."\n";
                        $m_error_import->description .= "<strong>Date dépôt CHQ PEC: </strong>".$mid->date_depot_chq_pec."\n";
                        $m_error_import->description .= "<strong>Date dépôt CHQ Part MUT: </strong>".$mid->date_depot_chq_part_mut."\n";
                        $m_error_import->description .= "<strong>Date dépôt CHQ RAC: </strong>".$mid->date_depot_chq_rac."\n";
                        $m_error_import->save();
                    }
            $m_prothese_empreintes = ProtheseEmpreinte::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_empreintes->laboratoire = trim($mid->laboratoire);
            $m_prothese_empreintes->date_empreinte = $imp_devis->makeDate($mid->date_empreinte);
            $m_prothese_empreintes->date_envoi_labo = $imp_devis->makeDate($mid->date_envoi_labo);
            $m_prothese_empreintes->travail_demande = $mid->travail_demande;
            $m_prothese_empreintes->numero_dent = trim($mid->numero_dent);
            $m_prothese_empreintes->observations = $mid->empreinte_observation;
            try {
                $m_prothese_empreintes->save();
                    }catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "INFO D'EMPREINTE";
                        $m_error_import->description .= "<strong>Laboratoire: </strong>".$mid->laboratoire."\n";
                        $m_error_import->description .= "<strong>Date D'empreinte: </strong>".$mid->date_empreinte."\n";
                        $m_error_import->description .= "<strong>Date d'envoi au labo: </strong>".$mid->date_envoi_labo."\n";
                        $m_error_import->description .= "<strong>Travail demandé: </strong>".$mid->travail_demande."\n";
                        $m_error_import->description .= "<strong>N° dent: </strong>".$mid->numero_dent."\n";
                        $m_error_import->description .= "<strong>Observations: </strong>".$mid->empreinte_observation."\n";
                        $m_error_import->save();
                    }
            $m_prothese_retour_labos = ProtheseRetourLabo::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_retour_labos->date_livraison = $imp_devis->makeDate($mid->date_livraison);
            $m_prothese_retour_labos->numero_suivi = trim($mid->numero_suivi);
            $m_prothese_retour_labos->numero_facture_labo = trim($mid->numero_facture_labo);
            try {
                $m_prothese_retour_labos->save();
                    }catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "RETOUR LABO";
                        $m_error_import->description .= "<strong>Date livraison: </strong>".$mid->date_livraison."\n";
                        $m_error_import->description .= "<strong>Numéro suivi colis de retour + société de livraison: </strong>".$mid->numero_suivi."\n";
                        $m_error_import->description .= "<strong>N° Facture Labo: </strong>".$mid->numero_facture_labo."\n";
                        $m_error_import->save();
                    }
            $m_prothese_travaux = ProtheseTravaux::firstOrNew(['id_devis' => $m_devis->id]);
            $m_prothese_travaux->date_pose_prevue = $imp_devis->makeDate($mid->date_pose_prevue);
/*-------*/ if ($m_protheseTravauxStatus) $m_prothese_travaux->id_pose_statut = $m_protheseTravauxStatus->id;
            $m_prothese_travaux->date_pose_reel = $imp_devis->makeDate($mid->date_pose_reel);
            $m_prothese_travaux->organisme_payeur = trim($mid->organisme_payeur);
            if ($mid->montant_encaisse && $mid->montant_encaisse != '') $m_prothese_travaux->montant_encaisse = trim($mid->montant_encaisse);
            $m_prothese_travaux->date_controle_paiement = $imp_devis->makeDate($mid->date_controle_paiement);
            try {
                $m_prothese_travaux->save();
                    } catch (\Exception $e){
                        $m_error_import = new ErrorImport();
                        $m_error_import->type = 1; // ne change pas
                        $m_error_import->date = $mid->date; // ne change pas
                        $m_error_import->dossier = $mid->dossier;
                        $m_error_import->error_message = $e->getMessage();
                        $m_error_import->categorie = "POSE & TRAVAUX CLOTURE";
                        $m_error_import->description .= "<strong>Date pose prévue: </strong>".$mid->date_pose_prevue."\n";
                        $m_error_import->description .= "<strong>Statut: </strong>".$mid->pose_statut."\n";
                        $m_error_import->description .= "<strong>Date pose réelle: </strong>".$mid->date_pose_reel."\n";
                        $m_error_import->description .= "<strong>Organisme payeur: </strong>".$mid->organisme_payeur."\n";
                        $m_error_import->description .= "<strong>Montant encaissé: </strong>".$mid->montant_encaisse."\n";
                        $m_error_import->description .= "<strong>Date ou vous devez contrôler paiement: </strong>".$mid->date_controle_paiement."\n";
                        $m_error_import->save();
                    }
            $m_info_cheques = InfoCheque::firstOrNew(['id_devis' => $m_devis->id]);
            $m_info_cheques->numero_cheque = trim($mid->numero_cheque);
/*-nombre-*/if ($mid->montant_cheque && $mid->montant_cheque != '') $m_info_cheques->montant_cheque = trim($mid->montant_cheque);
            $m_info_cheques->nom_document = trim($mid->nom_document);
            $m_info_cheques->date_encaissement_cheque = $imp_devis->makeDate($mid->date_encaissement_cheque);
            $m_info_cheques->date_1er_acte = $imp_devis->makeDate($mid->date_1er_acte);
            $m_info_cheques->nature_cheque = trim($mid->nature_cheque); // ao amle table ilay izy misy valeurs dooly ny primary key fa ato otrany to tsisy
            $m_info_cheques->travaux_sur_devis = trim($mid->travaux_sur_devis);
            $m_info_cheques->situation_cheque = trim($mid->situation_cheque);
            $m_info_cheques->observation = $mid->cheque_observation;
            try {
                $m_info_cheques->save();
            }catch (\Exception $e){
                $m_error_import = new ErrorImport();
                $m_error_import->type = 1; // ne change pas
                $m_error_import->date = $mid->date; // ne change pas
                $m_error_import->dossier = $mid->dossier;
                $m_error_import->error_message = $e->getMessage();
                $m_error_import->categorie = "INFO CHEQUES";
                $m_error_import->description .= "<strong>Numéro de chèque: </strong>".$mid->numero_cheque."\n";
                $m_error_import->description .= "<strong>Montant chèque: </strong>".$mid->montant_cheque."\n";
                $m_error_import->description .= "<strong>Nom document: </strong>".$mid->nom_document."\n";
                $m_error_import->description .= "<strong>Date encaissement: </strong>".$mid->date_encaissement_cheque."\n";
                $m_error_import->description .= "<strong>Date 1er acte: </strong>".$mid->date_1er_acte."\n";
                $m_error_import->description .= "<strong>Nature chèque: </strong>".$mid->nature_cheque."\n";
                $m_error_import->description .= "<strong>Travaux sur devis: </strong>".$mid->travaux_sur_devis."\n";
                $m_error_import->description .= "<strong>Situation chèque: </strong>".$mid->situation_cheque."\n";
                $m_error_import->description .= "<strong>Observation: </strong>".$mid->cheque_observation."\n";
                $m_error_import->save();
            }
        }
        $m_v_devis = new V_Devis();
        $m_v_devis->makeSessionListeDevis();
        return back()->with('success', 'Fichier importé avec succès!');
    }
    public function showImports(){
        return view('imports/imports');
    }
}
