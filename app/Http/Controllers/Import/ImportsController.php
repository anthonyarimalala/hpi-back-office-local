<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\CaImport;
use App\Imports\DevisImport;
use App\Models\ca\CaGeneral;
use App\Models\ca\L_CaActesReglement;
use App\Models\devis\cheque\InfoCheque;
use App\Models\devis\cheque\InfoChequeNatureCheque;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use App\Models\devis\Devis;
use App\Models\devis\DevisAccordPec;
use App\Models\devis\DevisAccordPecStatus;
use App\Models\devis\DevisAppelsEtMail;
use App\Models\devis\DevisEtat;
use App\Models\devis\DevisReglement;
use App\Models\devis\prothese\ProtheseEmpreinte;
use App\Models\devis\prothese\ProtheseRetourLabo;
use App\Models\devis\prothese\ProtheseTravaux;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use App\Models\dossier\Dossier;
use App\Models\dossier\DossierStatus;
use App\Models\error\ErrorImport;
use App\Models\hist\H_Cheque;
use App\Models\hist\H_Devis;
use App\Models\hist\H_Prothese;
use App\Models\import\ImportCa;
use App\Models\import\ImportDevis;
use App\Models\praticien\Praticien;
use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);
        // $action = $request->input('action');
        $file = $request->file('caFile');
        $m_import_ca = new ImportCa();
        DB::delete('DELETE FROM import_ca_actes_reglements');
        DB::delete('DELETE FROM errors_imports');
        Excel::import(new CaImport, $file);
        $withErrors = false;

        $m_import_cas = ImportCa::all();
        $m_import_devis = new ImportDevis();

        // Obtenir tous les clés primaires pour éviter de faire trop de requetes vers la base de donnée
        $m_praticienS = Praticien::all()->keyBy('praticien');

        foreach ($m_import_cas as $mic) {
            if (!$mic->dossier || $mic->dossier == '') {
                continue;
            }
            // step 1: Dossier
            $m_dossier = Dossier::firstOrNew(['dossier' => $mic->dossier]);
            $m_dossier->nom = $mic->nom_patient;
            $m_dossier->save();
            $m_praticien = $m_praticienS->get(strtoupper(trim($mic->praticien)));
            if (!$m_praticien) {
                $m_praticien = new Praticien();
                $m_praticien->praticien = strtoupper(trim($mic->praticien));
                $m_praticien->save();
            }
            // mise en place des erreurs
            $m_error_import = new ErrorImport();
            $m_error_import->type = 2; // ne change pas
            $m_error_import->date = Date::excelToDateTimeObject((float)trim($mic->date_derniere_modif))->format('Y-m-d');
            $m_error_import->dossier = $mic->dossier;
            $m_error_import->error_message = '';


            try {
                if ($mic->date && $mic->date != '') {
                    $date = $m_import_devis->makeDateOrError($mic->date);

                } else {
                    $date = date('Y-m-d');
                }
            } catch (Exception $e) {
                $date = null;
                $m_error_import->error_message .= 'Date : ' . $mic->date;;
            }

            $m_ca_generale = CaGeneral::where('dossier', $mic->dossier)
                ->where('statut', $mic->statut)
                ->where(function ($query) use ($mic) {
                    $query->where('mutuelle', '')
                        ->orWhere('mutuelle', $mic->mutuelle);
                })
                ->whereDate('created_at', $date)
                ->first();

            /*
            $query = CaGeneral::where('dossier', $mic->dossier)
            ->where('statut', $mic->statut)
            ->where(function ($query) use ($mic) {
                $query->whereNull('mutuelle')
                        ->orWhere('mutuelle', $mic->mutuelle);
            })
            ->whereDate('created_at', $date);

            // Récupérer la requête SQL brute
            $sql = $query->toSql();

            // Récupérer les valeurs bindées
            $bindings = $query->getBindings();

            // Remplacer les `?` dans la requête par les bindings (approche simple pour affichage/debug)
            foreach ($bindings as $binding) {
                // Ajouter des quotes autour des chaînes
                $binding = is_numeric($binding) ? $binding : "'$binding'";
                $sql = preg_replace('/\?/', $binding, $sql, 1);
            }

            echo $sql . '<br>';
            */

            if (!$m_ca_generale) {
                $m_devis = Devis::where('dossier', $mic->dossier)
                                ->where('status', $mic->status)
                                ->where('mutuelle', $mic->mutuelle)
                                ->whereDate('date', $date)
                                ->first();
                $m_ca_generale = new CaGeneral();
                $m_ca_generale->dossier = $mic->dossier;
                $m_ca_generale->nom_patient = $mic->nom_patient;
                $m_ca_generale->statut = $mic->statut;
                $m_ca_generale->mutuelle = $mic->mutuelle;
                $m_ca_generale->created_at = $date;
                if($m_devis){
                    $m_ca_generale->id_devis = $m_devis->id;
                }
                $m_ca_generale->save();
            }
            $m_ca = L_CaActesReglement::where('id_ca', $m_ca_generale->id)
                ->where('praticien', $m_praticien->praticien)
                ->where('nom_acte', $mic->nom_acte)
                ->whereDate('created_at', $date)
                ->first();
            //echo '$m_ca_generale->id_ca= '.$m_ca_generale->id. '<br>';
            //echo 'ca: '. '<br>' .$m_ca. '<br>';


            if (!$m_ca) {
                $m_ca = new L_CaActesReglement();
                $m_ca->id_ca = $m_ca_generale->id;
                $m_ca->praticien = $m_praticien->praticien;
                $m_ca->nom_acte = $mic->nom_acte;
                $m_ca->created_at = $date;
                //$m_ca->save();
                echo '--- Mbola tsy misy ---: '.$date. ' ? '.$m_ca->created_at;
            }else{
                echo '--- Efa misy ---: '.$date. ' ? '.$m_ca->created_at;

            }



            try {
                if ($mic->date_derniere_modif && $mic->date_derniere_modif != '') {
                    $date_derniere_modif = $m_import_devis->makeDateOrError($mic->date_derniere_modif);
                } else {
                    $date_derniere_modif = date('Y-m-d');
                }
            } catch (Exception $e) {
                $date_derniere_modif = null;
                $m_error_import->error_message .= 'Date de dernière modification non conforme: ' . $mic->date_derniere_modif;;
            }


            // date de dernière modification
            $m_ca->date_derniere_modif = $date_derniere_modif;
            // praticien
            $m_ca->praticien = trim($mic->praticien);
            // nom_acte
            $m_ca->nom_acte = trim($mic->nom_acte);
            // cotation
            if ($mic->cotation && $mic->cotation != '') {
                try {
                    $m_ca->cotation = $mic->makeNumericOrError($mic->cotation);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Cotation non conforme, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // controle_securisation
            $m_ca->controle_securisation = trim($mic->controle_securisation);
            // ro_part_secu
            if ($mic->ro_part_secu && $mic->ro_part_secu != '') {
                try {
                    $m_ca->ro_part_secu = $mic->makeNumericOrError($mic->ro_part_secu);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RO - Part Sécu non conforme, ';
                    $m_error_import->description .= "<strong>ro_part_secu: </strong>" . $mic->ro_part_secu . "\n";
                }
            }

            // ro_virement_recu
            if ($mic->ro_virement_recu && $mic->ro_virement_recu != '') {
                try {
                    $m_ca->ro_virement_recu = $mic->makeNumericOrError($mic->ro_virement_recu);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RO- Virement reçu, ';
                    $m_error_import->description .= "<strong>ro_virement_recu: </strong>" . $mic->ro_virement_recu . "\n";
                }
            }

            // ro_indus_paye
            if ($mic->ro_indus_paye && $mic->ro_indus_paye != '') {
                try {
                    $m_ca->ro_indus_paye = $mic->makeNumericOrError($mic->ro_indus_paye);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RO - Indus payé , ';
                    $m_error_import->description .= "<strong>ro_indus_paye: </strong>" . $mic->ro_indus_paye . "\n";
                }
            }

            // ro_indus_en_attente
            if ($mic->ro_indus_en_attente && $mic->ro_indus_en_attente != '') {
                try {
                    $m_ca->ro_indus_en_attente = $mic->makeNumericOrError($mic->ro_indus_en_attente);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RO - Indus en attente, ';
                    $m_error_import->description .= "<strong>ro_indus_en_attente: </strong>" . $mic->ro_indus_en_attente . "\n";
                }
            }

            // ro_indus_irrecouvrable
            if ($mic->ro_indus_irrecouvrable && $mic->ro_indus_irrecouvrable != '') {
                try {
                    $m_ca->ro_indus_irrecouvrable = $mic->makeNumericOrError($mic->ro_indus_irrecouvrable);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RO - Indus irrecouvrable, ';
                    $m_error_import->description .= "<strong>ro_indus_irrecouvrable: </strong>" . $mic->ro_indus_irrecouvrable . "\n";
                }
            }

            // part_mutuelle
            if ($mic->part_mutuelle && $mic->part_mutuelle != '') {
                try {
                    $m_ca->part_mutuelle = $mic->makeNumericOrError($mic->part_mutuelle);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Part mutuelle, ';
                    $m_error_import->description .= "<strong>part_mutuelle: </strong>" . $mic->part_mutuelle . "\n";
                }
            }
            // rcs_virement
            if ($mic->rcs_virement && $mic->rcs_virement != '') {
                try {
                    $m_ca->rcs_virement = $mic->makeNumericOrError($mic->rcs_virement);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RC SOINS - Virement, ';
                    $m_error_import->description .= "<strong>rcs_virement: </strong>" . $mic->rcs_virement . "\n";
                }
            }
            // rcs_especes
            if ($mic->rcs_especes && $mic->rcs_especes != '') {
                try {
                    $m_ca->rcs_especes = $mic->makeNumericOrError($mic->rcs_especes);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RC SOINS - Espèces, ';
                    $m_error_import->description .= "<strong>rcs_especes: </strong>" . $mic->rcs_especes . "\n";
                }
            }
            // rcs_especes
            if ($mic->rcs_cb && $mic->rcs_cb != '') {
                try {
                    $m_ca->rcs_cb = $mic->makeNumericOrError($mic->rcs_cb);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RC SOINS - CB, ';
                    $m_error_import->description .= "<strong>rcs_especes: </strong>" . $mic->rcs_cb . "\n";
                }
            }

            // rcs_cb
            if ($mic->rcs_cb && $mic->rcs_cb != '') {
                try {
                    $m_ca->rcs_cb = $mic->makeNumericOrError($mic->rcs_cb);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RAC - Part patient, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rcsd_cheque
            if ($mic->rcsd_cheque && $mic->rcsd_cheque != '') {
                try {
                    $m_ca->rcsd_cheque = $mic->makeNumericOrError($mic->rcsd_cheque);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RAC - Chèque, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rcsd_especes
            if ($mic->rcsd_especes && $mic->rcsd_especes != '') {
                try {
                    $m_ca->rcsd_especes = $mic->makeNumericOrError($mic->rcsd_especes);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RAC - Espèces, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rcsd_cb
            if ($mic->rcsd_cb && $mic->rcsd_cb != '') {
                try {
                    $m_ca->rcsd_cb = $mic->makeNumericOrError($mic->rcsd_cb);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'RAC - CB, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rac_part_patient
            if ($mic->rac_part_patient && $mic->rac_part_patient != '') {
                try {
                    $m_ca->rac_part_patient = $mic->makeNumericOrError($mic->rac_part_patient);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Cotation non conforme, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rac_cheque
            if ($mic->rac_cheque && $mic->rac_cheque != '') {
                try {
                    $m_ca->rac_cheque = $mic->makeNumericOrError($mic->rac_cheque);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Cotation non conforme, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rac_especes
            if ($mic->rac_especes && $mic->rac_especes != '') {
                try {
                    $m_ca->rac_especes = $mic->makeNumericOrError($mic->rac_especes);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Cotation non conforme, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            // rac_cb
            if ($mic->rac_cb && $mic->rac_cb != '') {
                try {
                    $m_ca->rac_cb = $mic->makeNumericOrError($mic->rac_cb);
                } catch (Exception $e) {
                    $m_error_import->error_message .= 'Cotation non conforme, ';
                    $m_error_import->description .= "<strong>Cotation: </strong>" . $mic->cotation . "\n";
                }
            }
            $m_ca->commentaire = trim($mic->commentaire);
            $m_ca->save();

        }
        if ($m_error_import->error_message != '') {
            $m_error_import->save();
            $withErrors = true;
        }
        if (!$withErrors)
            return back()->with('success', 'Fichier importé avec succès');
        else
            return redirect('erreur-import-1');
            //return back()->with('warning', 'Données importées mais contiennent des erreurs');
    }


    public function importerDevis(Request $request)
    {

        $withErrorsAll = false;
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
        $m_import_deviss = ImportDevis::where('dossier', '!=', null)->get();

        // Obtenir tous les clés primaires pour éviter de faire trop de requetes vers la base de donnée
        $m_protheseTravauxStatusS = ProtheseTravauxStatus::all()->keyBy('travaux_status');
        $m_devis_etatsS = DevisEtat::all()->keyBy('couleur');
        $m_dossier_statusS = DossierStatus::all()->keyBy('status');
        $m_praticienS = Praticien::all()->keyBy('praticien');
        $m_nature_chequeS = InfoChequeNatureCheque::all()->keyBy('nature_cheque');
        $m_travaux_sur_devisS = InfoChequeTravauxDevis::all()->keyBy('travaux_sur_devis');
        $m_situation_chequeS = InfoChequeSituationCheque::all()->keyBy('situation_cheque');
        $m_devis_accord_pecs_statusS = DevisAccordPecStatus::all()->keyBy('status');

        foreach ($m_import_deviss as $mid){
//             // déclaration de nouvelle variable d'historique

            $withErrors = false;
            $m_error_import = new ErrorImport();
            $m_error_import->type = 1;
            $m_error_import->dossier = trim($mid->dossier);

//             // Step 1: dossier
            $m_dossier = Dossier::firstOrNew(['dossier' => trim($mid->dossier)]);
            $m_devis_etat = $m_devis_etatsS->get(trim($mid->couleur));
            $m_dossier->nom = trim($mid->nom);
            $m_dossier->status = $m_dossier_statusS->get(trim($mid->status));
            if (!$m_dossier->status){
                $m_error_import->error_message = "Le status ". trim($mid->status) . "n'est pas encore dans la base de donnée";
                $m_dossier->status = '';
                $withErrors = true;
            }else{
                $m_dossier->status = $m_dossier->status->status;
            }
            $m_dossier->mutuelle = trim($mid->mutuelle);
            $m_dossier->save();

            //  Step 2: devis
            $date_devis = null;
            if ($mid->date && $mid->date != ''){
                try {
                    $date_devis = $mid->makeDateOrError($mid->date);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= 'Date non conforme, ';
                    $m_error_import->description.= "<strong>Date: </strong>".$mid->date."\n";
                    $withErrors = true;
                }
            }
            $m_prtc = $m_praticienS->get(strtoupper(trim($mid->praticien)));
            $prtc = null;
            if (!$m_prtc){
                $m_prtc = new Praticien();
                $m_prtc->praticien = strtoupper(trim($mid->praticien));
                $m_prtc->save();
            }
            $prtc = $m_prtc->praticien;

            $m_devis = Devis::firstOrNew(['dossier' => $mid->dossier, 'status' => $m_dossier->status ,'date' => $date_devis, 'praticien' => $prtc]);
            $m_devis->mutuelle = trim($mid->mutuelle);
            if ($mid->montant && $mid->montant != ''){
                try {
                    $m_devis->montant = $mid->makeNumericOrError($mid->montant);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= 'Montant non conforme, ';
                    $m_error_import->description.= "<strong>Montant: </strong>".$mid->montant."\n";
                    $withErrors = true;
                }
            }
            $m_devis->save();
            // pour l'historique de changement
            $m_devis_nouveau = clone $m_devis;
            $m_devis_nouveau->devis_signe = $imp_devis->makeDevisSigne($mid->devis_signe) ;
            $m_devis_nouveau->observation = $mid->devis_observation;
            if($m_devis_etat) $m_devis_nouveau->id_devis_etat = $m_devis_etat->id; else $m_devis_nouveau->id_devis_etat = 1;


            $m_h_devis = new H_Devis();
            $m_h_devis->code_u = Auth::user()->code_u;
            $m_h_devis->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
            $m_h_devis->dossier = $m_dossier->dossier;
            $m_h_devis->id_devis = $m_devis->id;
            $m_h_devis->action .= "Données importés: " . "\n";


            $withChange = false;
            Devis::updateDevis($m_h_devis, $m_devis_etatsS, $m_devis, $m_devis_nouveau, $withChange);

            //  Step 3: Info Accord Pec
            $date_envoie_pec = null;
            $date_fin_validite_pec = null;
            $part_secu = null;
            $part_secu_status = null;
            $part_mutuelle = null;
            $part_mutuelle_status = null;
            $part_rac = null;
            $part_rac_status = null;

            if ($mid->date_envoi_pec && $mid->date_envoi_pec!=''){
                try {
                    $date_envoie_pec = $mid->makeDateOrError($mid->date_envoi_pec);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= "Date d'envoi PEC non conforme, ";
                    $m_error_import->description.= "<strong>Date d'envoi PEC: </strong>".$mid->date_envoi_pec."\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_fin_validite_pec && $mid->date_fin_validite_pec != '') {
                try {
                    $date_fin_validite_pec = $mid->makeDateOrError($mid->date_fin_validite_pec);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= "Date de fin de validité PEC non conforme, ";
                    $m_error_import->description .= "<strong>Date de fin de validité PEC: </strong>".$mid->date_fin_validite_pec."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_secu && $mid->part_secu != ''){
                try {
                    $part_secu = $mid->makeNumericOrError($mid->part_secu);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= "Part secu non conforme, ";
                    $m_error_import->description.= "<strong>Part Secu: </strong>".$mid->part_secu."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_secu_status){
                $stt = $m_devis_accord_pecs_statusS->get(trim($mid->part_secu_status));
                if ($stt){
                    $part_secu_status = $stt->status;
                    //echo('part_secu_status: ' . $mid->part_secu_status.'<br>');
                }
                else {
                    $m_error_import->error_message .= "Part secu: ";
                    $m_error_import->description.= "<strong>Part Secu: </strong>".$mid->part_secu_status."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_mutuelle && $mid->part_mutuelle != ''){
                try {
                    $part_mutuelle = $mid->makeNumericOrError($mid->part_mutuelle);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= "Part mutuelle non conforme, ";
                    $m_error_import->description.= "<strong>Part mutuelle: </strong>".$mid->part_mutuelle."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_mutuelle_status){
                $stt = $m_devis_accord_pecs_statusS->get(trim($mid->part_mutuelle_status));
                if ($stt){
                    $part_mutuelle_status = $stt->status;
                    //echo('part_mutuelle_status: ' . $mid->part_mutuelle_status.'<br>');
                }
                else{
                    $m_error_import->error_message .= "Part mutuelle: ";
                    $m_error_import->description.= "<strong>Part Mutuelle: </strong>".$mid->part_mutuelle_status."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_rac && $mid->part_rac != '') {
                try {
                    $part_rac = $mid->makeNumericOrError($mid->part_rac);
                }
                catch (\Exception $e){
                    $m_error_import->error_message .= "Part RAC non conforme, ";
                    $m_error_import->description .= "<strong>Part RAC: </strong>".$mid->part_rac."\n";
                    $withErrors = true;
                }
            }
            if ($mid->part_rac_status){
                $stt = $m_devis_accord_pecs_statusS->get(trim($mid->part_rac_status));
                if ($stt){
                    $part_rac_status = $stt->status;
                    //echo ('part_rac_status: ' . $mid->part_rac_status.'<br>');
                }
                else{
                    $m_error_import->error_message .= "Part RAC: ";
                    $m_error_import->description.= "<strong>Part RAC: </strong>".$mid->part_rac_status."\n";
                    $withErrors = true;
                }
            }

            DevisAccordPec::createOrUpdateDevisAccordPecs($m_h_devis, $m_devis_nouveau->id, $date_envoie_pec, $date_fin_validite_pec, $part_secu, $part_secu_status, $part_mutuelle, $part_mutuelle_status, $part_rac, $part_rac_status, $withChange);

            // step 4: devis appels et mail
            $date_1er_appel = null;
            $note_1er_appel = $mid->note_1er_appel;
            $date_2eme_appel = null;
            $note_2eme_appel = $mid->note_2eme_appel;
            $date_3eme_appel = null;
            $note_3eme_appel = $mid->note_3eme_appel;
            $date_envoi_mail = null;
            if ($mid->date_1er_appel && $mid->date_1er_appel != '') {
                try {
                    $date_1er_appel = $imp_devis->makeDateOrError($mid->date_1er_appel);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date 1er appel non conforme, ";
                    $m_error_import->description .= "<strong>Date 1er appel: </strong>" . $mid->date_1er_appel . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_2eme_appel && $mid->date_2eme_appel != '') {
                try {
                    $date_2eme_appel = $imp_devis->makeDateOrError($mid->date_2eme_appel);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date 2ème appel non conforme, ";
                    $m_error_import->description .= "<strong>Date 2ème appel: </strong>" . $mid->date_2eme_appel . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_3eme_appel && $mid->date_3eme_appel != '') {
                try {
                    $date_3eme_appel = $imp_devis->makeDateOrError($mid->date_3eme_appel);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date 3ème appel non conforme, ";
                    $m_error_import->description .= "<strong>Date 3ème appel: </strong>" . $mid->date_3eme_appel . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_envoi_mail && $mid->date_envoi_mail != '') {
                try {
                    $date_envoi_mail = $imp_devis->makeDateOrError($mid->date_envoi_mail);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date d'envoi mail non conforme, ";
                    $m_error_import->description .= "<strong>Date envoi mail: </strong>" . $mid->date_envoi_mail . "\n";
                    $withErrors = true;
                }
            }

            DevisAppelsEtMail::createDevisAppelsEtMailDate_Non_Automatic(
                $m_h_devis,
                $m_devis_nouveau->id,
                $date_1er_appel,
                $note_1er_appel,
                $date_2eme_appel,
                $note_2eme_appel,
                $date_3eme_appel,
                $note_3eme_appel,
                $date_envoi_mail,
                $withChange);


            // step 4: Devis Reglement
            $reglement_cb = null;
            $reglement_espece = null;
            $date_paiement_cb_ou_esp = null;
            $date_depot_chq_pec = null;
            $date_depot_chq_part_mut = null;
            $date_depot_chq_rac = null;

            if ($mid->reglement_cb && $mid->reglement_cb != '') {
                try {
                    $reglement_cb = $mid->reglement_cb;
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Reglement, ";
                    $m_error_import->description .= "<strong>Reglement, CB: </strong>" . $mid->reglement_cb . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->reglement_espece && $mid->reglement_espece != '') {
                try {
                    $reglement_espece = $mid->reglement_espece;
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Reglement, ";
                    $m_error_import->description .= "<strong>Reglement, espece: </strong>" . $mid->reglement_espece . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_paiement_cb_ou_esp && $mid->date_paiement_cb_ou_esp != '') {
                try {
                    $date_paiement_cb_ou_esp = $imp_devis->makeDateOrError($mid->date_paiement_cb_ou_esp);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date paiement CB ou ESP non conforme, ";
                    $m_error_import->description .= "<strong>Date paiement CB ou ESP: </strong>" . $mid->date_paiement_cb_ou_esp . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_depot_chq_pec && $mid->date_depot_chq_pec != '') {
                try {
                    $date_depot_chq_pec = $imp_devis->makeDateOrError($mid->date_depot_chq_pec);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date dépôt chèque PEC non conforme, ";
                    $m_error_import->description .= "<strong>Date dépôt chèque PEC: </strong>" . $mid->date_depot_chq_pec . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_depot_chq_part_mut && $mid->date_depot_chq_part_mut != '') {
                try {
                    $date_depot_chq_part_mut = $imp_devis->makeDateOrError($mid->date_depot_chq_part_mut);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date dépôt chèque part mutuelle non conforme, ";
                    $m_error_import->description .= "<strong>Date dépôt chèque part mutuelle: </strong>" . $mid->date_depot_chq_part_mut . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_depot_chq_rac && $mid->date_depot_chq_rac != '') {
                try {
                    $date_depot_chq_rac = $imp_devis->makeDateOrError($mid->date_depot_chq_rac);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date dépôt chèque RAC non conforme, ";
                    $m_error_import->description .= "<strong>Date dépôt chèque RAC: </strong>" . $mid->date_depot_chq_rac . "\n";
                    $withErrors = true;
                }
            }

            DevisReglement::createDevisReglement(
                $m_h_devis,
                $m_devis_nouveau->id,
                $reglement_cb,
                $reglement_espece,
                $date_paiement_cb_ou_esp,
                $date_depot_chq_pec,
                $date_depot_chq_part_mut,
                $date_depot_chq_rac,
                $withChange);

            $m_h_prothese = new H_Prothese();
            $m_h_prothese->code_u = Auth::user()->code_u;
            $m_h_prothese->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
            $m_h_prothese->dossier = $m_dossier->dossier;
            $m_h_prothese->id_devis = $m_devis->id;
            $m_h_prothese->action .= "Données importés: (Date devis: ". $m_devis_nouveau->date .")" . "\n";
            $withChangeProthese = false;

            // step 5: prothese empreinte
            $laboratoire = trim($mid->laboratoire);
            $date_empreinte = null;
            $date_envoi_labo = null;
            $travail_demande = $mid->travail_demande;
            $numero_dent = trim($mid->numero_dent);
            $observation = $mid->empreinte_observation;

            if ($mid->date_empreinte && $mid->date_empreinte != '') {
                try {
                    $date_empreinte = $imp_devis->makeDateOrError($mid->date_empreinte);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date empreinte non conforme, ";
                    $m_error_import->description .= "<strong>Date empreinte: </strong>" . $mid->date_empreinte . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_envoi_labo && $mid->date_envoi_labo != '') {
                try {
                    $date_envoi_labo = $imp_devis->makeDateOrError($mid->date_envoi_labo);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date envoi labo non conforme, ";
                    $m_error_import->description .= "<strong>Date envoi labo: </strong>" . $mid->date_envoi_labo . "\n";
                    $withErrors = true;
                }
            }

            $m_prothese_empreinte = ProtheseEmpreinte::firstOrNew(['id_devis' => $m_devis->id, 'travail_demande' => trim($mid->travail_demande)]);
            $m_prothese_empreinte->save();


            ProtheseEmpreinte::createOrUpdateEmpreinte(
                $m_h_prothese,
                $m_devis_nouveau->id,
                $m_prothese_empreinte->id,
                $laboratoire,
                $date_empreinte,
                $date_envoi_labo,
                $travail_demande,
                $mid->montant_acte,
                $numero_dent,
                $observation,
                $date_devis,
                $withChangeProthese
            );


            // step 6: prothese retour labo
            $date_livraison = null;
            $numero_suivi = trim($mid->numero_suivi);
            $numero_facture_labo = trim($mid->numero_facture_labo);
            if ($mid->date_livraison && $mid->date_livraison != '') {
                try {
                    $date_livraison = $imp_devis->makeDateOrError($mid->date_livraison);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date livraison non conforme, ";
                    $m_error_import->description .= "<strong>Date livraison: </strong>" . $mid->date_livraison . "\n";
                    $withErrors = true;
                }
            }
            ProtheseRetourLabo::createOrUpdateEmpreinte(
                $m_h_prothese,
                $m_prothese_empreinte->id,
                $date_livraison,
                $numero_suivi,
                $numero_facture_labo,
                $withChangeProthese
            );

            // step 7: prothese travaux
            $m_protheseTravauxStatus = $m_protheseTravauxStatusS->get(trim($mid->pose_statut));
            $date_pose_prevue = null;
            $id_pose_status = null;
            $date_pose_reel = null;
            $organisme_payeur = trim($mid->organisme_payeur);
            $montant_encaisse = null;
            $date_controle_paiement = null;
            if ($mid->date_pose_prevue && $mid->date_pose_prevue != '') {
                try {
                    $date_pose_prevue = $imp_devis->makeDateOrError($mid->date_pose_prevue);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date pose prévue non conforme, ";
                    $m_error_import->description .= "<strong>Date pose prévue: </strong>" . $mid->date_pose_prevue . "\n";
                    $withErrors = true;
                }
            }
            if ($m_protheseTravauxStatus){
                $id_pose_status = $m_protheseTravauxStatus->id;
            }else{
                $m_error_import->error_message = "Le status ". trim($mid->pose_statut) . "n'est pas encore dans la base de donnée";
                $id_pose_status = 1;
                $withErrors = true;
            }

            if ($mid->date_pose_reel && $mid->date_pose_reel != '') {
                try {
                    $date_pose_reel = $imp_devis->makeDateOrError($mid->date_pose_reel);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date pose réelle non conforme, ";
                    $m_error_import->description .= "<strong>Date pose réelle: </strong>" . $mid->date_pose_reel . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->montant_encaisse && $mid->montant_encaisse != '') {
                try {
                    $montant_encaisse = $imp_devis->makeNumericOrError($mid->montant_encaisse); // Utilisation d'une méthode pour le montant
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Montant encaissé non conforme, ";
                    $m_error_import->description .= "<strong>Montant encaissé: </strong>" . $mid->montant_encaisse . "\n";
                    $withErrors = true;
                }
            }

            if ($mid->date_controle_paiement && $mid->date_controle_paiement != '') {
                try {
                    $date_controle_paiement = $imp_devis->makeDateOrError($mid->date_controle_paiement); // Utilisation de makeDateOrError pour la date
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date contrôle paiement non conforme, ";
                    $m_error_import->description .= "<strong>Date contrôle paiement: </strong>" . $mid->date_controle_paiement . "\n";
                    $withErrors = true;
                }
            }

            ProtheseTravaux::createOrUpdateTravaux(
                $m_h_prothese,
                $m_prothese_empreinte->id,
                $date_pose_prevue,
                $id_pose_status,
                $date_pose_reel,
                $organisme_payeur,
                $montant_encaisse,
                $date_controle_paiement,
                $withChangeProthese
            );


            $m_h_cheque = new H_Cheque();
            $m_h_cheque->code_u = Auth::user()->code_u;
            $m_h_cheque->nom = Auth::user()->prenom . ' ' . Auth::user()->nom;
            $m_h_cheque->dossier = $m_dossier->dossier;
            $m_h_cheque->id_devis = $m_devis->id;
            $m_h_cheque->action .= "Données importés: (Date devis: ". $m_devis_nouveau->date .")" . "\n";
            $withChangeCheque = false;

            // step 8: cheque
            $numero_cheque = trim($mid->numero_cheque);
            $montant_cheque = null;
            $nom_document = trim($mid->nom_document);
            $date_encaissement_cheque = null;
            $date_1er_acte = null;
            $nature_cheque = $m_nature_chequeS->get(trim($mid->nature_cheque));
            $travaux_sur_devis = $m_travaux_sur_devisS->get(trim($mid->travaux_sur_devis));
            $situation_cheque = $m_situation_chequeS->get(trim($mid->situation_cheque));
            $observation = $mid->cheque_observation;

            if ($mid->montant_cheque && $mid->montant_cheque != '') {
                try {
                    $montant_cheque = $imp_devis->makeNumericOrError($mid->montant_cheque); // Utilisation d'une méthode pour vérifier si le montant est numérique
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Montant chèque non conforme, ";
                    $m_error_import->description .= "<strong>Montant chèque: </strong>" . $mid->montant_cheque . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_encaissement_cheque && $mid->date_encaissement_cheque != '') {
                try {
                    $date_encaissement_cheque = $imp_devis->makeDateOrError($mid->date_encaissement_cheque);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date d'encaissement chèque non conforme, ";
                    $m_error_import->description .= "<strong>Date encaissement chèque: </strong>" . $mid->date_encaissement_cheque . "\n";
                    $withErrors = true;
                }
            }
            if ($mid->date_1er_acte && $mid->date_1er_acte != '') {
                try {
                    $date_1er_acte = $imp_devis->makeDateOrError($mid->date_1er_acte);
                } catch (\Exception $e) {
                    $m_error_import->error_message .= "Date 1er acte non conforme, ";
                    $m_error_import->description .= "<strong>Date 1er acte: </strong>" . $mid->date_1er_acte . "\n";
                    $withErrors = true;
                }
            }
            if($nature_cheque){
                $nature_cheque = $nature_cheque->nature_cheque;
            }else{
                $m_error_import->error_message .= "La nature du cheque ". trim($mid->nature_cheque) . "n'est pas encore dans la base de donnée";
                $m_error_import->description .= "<strong>Nature Cheque: </strong>" . trim($mid->nature_cheque) . "\n";
                $nature_cheque = '';
                $withErrors = true;
            }
            if ($travaux_sur_devis) {
                $travaux_sur_devis = $travaux_sur_devis->travaux_sur_devis;
            } else {
                $m_error_import->error_message .= "Les travaux sur devis ".trim($mid->travaux_sur_devis)." n'est pas disponibles dans la base de données.\n";
                $m_error_import->description .= "<strong>Travaux sur devis: </strong>" . trim($mid->travaux_sur_devis) . "\n";
                $travaux_sur_devis = '';
                $withErrors = true;
            }

            if ($situation_cheque) {
                $situation_cheque = $situation_cheque->situation_cheque;
            } else {
                $m_error_import->error_message .= "La situation du chèque ".trim($mid->situation_cheque)." n'est pas disponible dans la base de données.\n";
                $m_error_import->description .= "<strong>Situation Chèque: </strong>" . trim($mid->situation_cheque) . "\n";
                $situation_cheque = '';
                $withErrors = true;
            }

            InfoCheque::modifierCheque(
                $m_h_cheque,
                $m_devis_nouveau->id,
                $numero_cheque,
                $montant_cheque,
                $nom_document,
                $date_encaissement_cheque,
                $date_1er_acte,
                $nature_cheque,
                $travaux_sur_devis,
                $situation_cheque,
                $observation,
                $withChangeCheque
            );
            if ($withChangeCheque){
                $m_h_cheque->save();
            }
            if ($withChangeProthese){
                $m_h_prothese->save();
            }
            if ($withChange){
                $m_h_devis->save();
            }
            if ($withErrors){
                $m_error_import->save();
            }
        }


        if (!$withErrorsAll)
            return back()->with('success', 'Fichier importé avec succès');
        else
            return redirect('erreur-import-2');
            //return back()->with('warning', 'Données importées mais contiennent des erreurs');

    }
    public function showImports(){
        return view('imports/imports');
    }
}
