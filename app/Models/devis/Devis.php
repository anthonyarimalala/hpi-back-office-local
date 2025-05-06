<?php

namespace App\Models\devis;

use App\Models\dossier\Dossier;
use App\Models\hist\H_Devis;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';
    protected $fillable = [
        'dossier',
        'status',
        'date',
        'praticien',
    ];

    public static function deleteActe($id_devis, $id_acte){
        $m_devis = Devis::find($id_devis);
        $m_h_devis = new H_Devis();
        $m_h_devis->code_u = Auth::user()->code_u;
        $m_h_devis->nom = Auth::user()->prenom. ' '. Auth::user()->nom;
        $m_h_devis->id_devis = $id_devis;
        $m_h_devis->dossier = $m_devis->dossier;
        $m_h_devis->categorie = 'delete';
        $m_h_devis->action .= "<strong>Dossier: </strong> " . $m_devis->dossier . "\n";
        $m_h_devis->action .= "<strong>ID Devis: </strong> " . $m_devis->id_devis . "\n";
        $m_h_devis->action .= "<strong>Nom: </strong> " . $m_devis->nom . "\n";
        $m_h_devis->action .= "<strong>Date de naissance: </strong> " . $m_devis->date_naissance . "\n";
        $m_h_devis->action .= "<strong>Status: </strong> " . $m_devis->status . "\n";
        $m_h_devis->action .= "<strong>Mutuelle: </strong> " . $m_devis->mutuelle . "\n";
        $m_h_devis->action .= "<strong>Date: </strong> " . $m_devis->date . "\n";
        $m_h_devis->action .= "<strong>Montant: </strong> " . $m_devis->montant . "\n";

        $m_h_devis->action .= "<strong>Laboratoire: </strong> " . $m_devis->laboratoire . "\n";
        $m_h_devis->action .= "<strong>Date empreinte: </strong> " . $m_devis->date_empreinte . "\n";
        $m_h_devis->action .= "<strong>Date envoi labo: </strong> " . $m_devis->date_envoi_labo . "\n";
        $m_h_devis->action .= "<strong>Travail demandé: </strong> " . $m_devis->travail_demande . "\n";
        $m_h_devis->action .= "<strong>Numéro dent: </strong> " . $m_devis->numero_dent . "\n";
        $m_h_devis->action .= "<strong>Empreinte observation: </strong> " . $m_devis->empreinte_observation . "\n";
        $m_h_devis->action .= "<strong>Date création: </strong> " . $m_devis->created_at . "\n";
        $m_h_devis->action .= "<strong>Date mise à jour: </strong> " . $m_devis->updated_at . "\n";
        $m_h_devis->action .= "<strong>Date livraison: </strong> " . $m_devis->date_livraison . "\n";
        $m_h_devis->action .= "<strong>Numéro suivi: </strong> " . $m_devis->numero_suivi . "\n";
        $m_h_devis->action .= "<strong>Numéro facture labo: </strong> " . $m_devis->numero_facture_labo . "\n";
        $m_h_devis->action .= "<strong>Date pose prévue: </strong> " . $m_devis->date_pose_prevue . "\n";
        $m_h_devis->action .= "<strong>ID pose statut: </strong> " . $m_devis->id_pose_statut . "\n";
        $m_h_devis->action .= "<strong>Pose statut: </strong> " . $m_devis->pose_statut . "\n";
        $m_h_devis->action .= "<strong>Date pose réel: </strong> " . $m_devis->date_pose_reel . "\n";
        $m_h_devis->action .= "<strong>Organisme payeur: </strong> " . $m_devis->organisme_payeur . "\n";
        $m_h_devis->action .= "<strong>Montant encaissé: </strong> " . $m_devis->montant_encaisse . "\n";
        $m_h_devis->action .= "<strong>Date contrôle paiement: </strong> " . $m_devis->date_controle_paiement . "\n";

        $m_h_devis->save();

        try {
            echo 'tokony delete izy ato';
            DB::delete('DELETE FROM protheses WHERE id = ?', [$id_acte]);
        } catch (Exception $e) {
            //throw $th;
        }


    }
    public static function deleteDevis($id_devis, $id_acte){
        $m_devis = Devis::find($id_devis);
        $m_h_devis = new H_Devis();
        $m_h_devis->code_u = Auth::user()->code_u;
        $m_h_devis->nom = Auth::user()->prenom. ' '. Auth::user()->nom;
        $m_h_devis->id_devis = $id_devis;
        $m_h_devis->dossier = $m_devis->dossier;
        $m_h_devis->categorie = 'delete';
        $m_h_devis->action .= "<strong>Dossier: </strong> " . $m_devis->dossier . "\n";
        $m_h_devis->action .= "<strong>ID Devis: </strong> " . $m_devis->id_devis . "\n";
        $m_h_devis->action .= "<strong>Nom: </strong> " . $m_devis->nom . "\n";
        $m_h_devis->action .= "<strong>Date de naissance: </strong> " . $m_devis->date_naissance . "\n";
        $m_h_devis->action .= "<strong>Status: </strong> " . $m_devis->status . "\n";
        $m_h_devis->action .= "<strong>Mutuelle: </strong> " . $m_devis->mutuelle . "\n";
        $m_h_devis->action .= "<strong>Date: </strong> " . $m_devis->date . "\n";
        $m_h_devis->action .= "<strong>Montant: </strong> " . $m_devis->montant . "\n";
        $m_h_devis->action .= "<strong>Devis signé: </strong> " . $m_devis->devis_signe . "\n";
        $m_h_devis->action .= "<strong>Praticien: </strong> " . $m_devis->praticien . "\n";
        $m_h_devis->action .= "<strong>Devis observation: </strong> " . $m_devis->devis_observation . "\n";
        $m_h_devis->action .= "<strong>Is deleted: </strong> " . $m_devis->is_deleted . "\n";
        $m_h_devis->action .= "<strong>Dernière modification: </strong> " . $m_devis->dernier_modif . "\n";
        $m_h_devis->action .= "<strong>Date envoi PEC: </strong> " . $m_devis->date_envoi_pec . "\n";
        $m_h_devis->action .= "<strong>Date fin validité PEC: </strong> " . $m_devis->date_fin_validite_pec . "\n";
        $m_h_devis->action .= "<strong>Part mutuelle: </strong> " . $m_devis->part_mutuelle . "\n";
        $m_h_devis->action .= "<strong>Part RAC: </strong> " . $m_devis->part_rac . "\n";
        $m_h_devis->action .= "<strong>Date paiement CB ou espèces: </strong> " . $m_devis->date_paiement_cb_ou_esp . "\n";
        $m_h_devis->action .= "<strong>Date dépôt chèque PEC: </strong> " . $m_devis->date_depot_chq_pec . "\n";
        $m_h_devis->action .= "<strong>Date dépôt chèque part mutuelle: </strong> " . $m_devis->date_depot_chq_part_mut . "\n";
        $m_h_devis->action .= "<strong>Date dépôt chèque RAC: </strong> " . $m_devis->date_depot_chq_rac . "\n";
        $m_h_devis->action .= "<strong>Date 1er appel: </strong> " . $m_devis->date_1er_appel . "\n";
        $m_h_devis->action .= "<strong>Note 1er appel: </strong> " . $m_devis->note_1er_appel . "\n";
        $m_h_devis->action .= "<strong>Date 2eme appel: </strong> " . $m_devis->date_2eme_appel . "\n";
        $m_h_devis->action .= "<strong>Note 2eme appel: </strong> " . $m_devis->note_2eme_appel . "\n";
        $m_h_devis->action .= "<strong>Date 3eme appel: </strong> " . $m_devis->date_3eme_appel . "\n";
        $m_h_devis->action .= "<strong>Note 3eme appel: </strong> " . $m_devis->note_3eme_appel . "\n";
        $m_h_devis->action .= "<strong>Date envoi mail: </strong> " . $m_devis->date_envoi_mail . "\n";
        $m_h_devis->action .= "<strong>ID devis état: </strong> " . $m_devis->id_devis_etat . "\n";
        $m_h_devis->action .= "<strong>État: </strong> " . $m_devis->etat . "\n";
        $m_h_devis->action .= "<strong>Couleur: </strong> " . $m_devis->couleur . "\n";
        $m_h_devis->action .= "<strong>Laboratoire: </strong> " . $m_devis->laboratoire . "\n";
        $m_h_devis->action .= "<strong>Date empreinte: </strong> " . $m_devis->date_empreinte . "\n";
        $m_h_devis->action .= "<strong>Date envoi labo: </strong> " . $m_devis->date_envoi_labo . "\n";
        $m_h_devis->action .= "<strong>Travail demandé: </strong> " . $m_devis->travail_demande . "\n";
        $m_h_devis->action .= "<strong>Numéro dent: </strong> " . $m_devis->numero_dent . "\n";
        $m_h_devis->action .= "<strong>Empreinte observation: </strong> " . $m_devis->empreinte_observation . "\n";
        $m_h_devis->action .= "<strong>Date création: </strong> " . $m_devis->created_at . "\n";
        $m_h_devis->action .= "<strong>Date mise à jour: </strong> " . $m_devis->updated_at . "\n";
        $m_h_devis->action .= "<strong>Date livraison: </strong> " . $m_devis->date_livraison . "\n";
        $m_h_devis->action .= "<strong>Numéro suivi: </strong> " . $m_devis->numero_suivi . "\n";
        $m_h_devis->action .= "<strong>Numéro facture labo: </strong> " . $m_devis->numero_facture_labo . "\n";
        $m_h_devis->action .= "<strong>Date pose prévue: </strong> " . $m_devis->date_pose_prevue . "\n";
        $m_h_devis->action .= "<strong>ID pose statut: </strong> " . $m_devis->id_pose_statut . "\n";
        $m_h_devis->action .= "<strong>Pose statut: </strong> " . $m_devis->pose_statut . "\n";
        $m_h_devis->action .= "<strong>Date pose réel: </strong> " . $m_devis->date_pose_reel . "\n";
        $m_h_devis->action .= "<strong>Organisme payeur: </strong> " . $m_devis->organisme_payeur . "\n";
        $m_h_devis->action .= "<strong>Montant encaissé: </strong> " . $m_devis->montant_encaisse . "\n";
        $m_h_devis->action .= "<strong>Date contrôle paiement: </strong> " . $m_devis->date_controle_paiement . "\n";
        $m_h_devis->action .= "<strong>Numéro chèque: </strong> " . $m_devis->numero_cheque . "\n";
        $m_h_devis->action .= "<strong>Montant chèque: </strong> " . $m_devis->montant_cheque . "\n";
        $m_h_devis->action .= "<strong>Nom document: </strong> " . $m_devis->nom_document . "\n";
        $m_h_devis->action .= "<strong>Date encaissement chèque: </strong> " . $m_devis->date_encaissement_cheque . "\n";
        $m_h_devis->action .= "<strong>Date 1er acte: </strong> " . $m_devis->date_1er_acte . "\n";
        $m_h_devis->action .= "<strong>Nature chèque: </strong> " . $m_devis->nature_cheque . "\n";
        $m_h_devis->action .= "<strong>Travaux sur devis: </strong> " . $m_devis->travaux_sur_devis . "\n";
        $m_h_devis->action .= "<strong>Situation chèque: </strong> " . $m_devis->situation_cheque . "\n";
        $m_h_devis->action .= "<strong>Chèque observation: </strong> " . $m_devis->cheque_observation . "\n";
        $m_h_devis->save();
        try{
            DB::delete('DELETE FROM protheses WHERE id = ?', [$id_acte]);
            DB::delete('DELETE FROM info_cheques WHERE id_devis = ?', [$id_devis]);
            DB::delete('DELETE FROM devis_appels_et_mails WHERE id_devis = ?', [$id_devis]);
            DB::delete('DELETE FROM devis_reglements WHERE id_devis = ?', [$id_devis]);
            DB::delete('DELETE FROM devis_accord_pecs WHERE id_devis = ?', [$id_devis]);
            DB::delete('DELETE FROM devis WHERE id = ?', [$id_devis]);
        }catch(Exception $e){
            echo $e;
        }
    }

    public static function createDevisSansDossier($dossier, $nom, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation){
        $m_dossier = Dossier::firstOrNew(['dossier'=> $dossier]);
        if ($m_dossier->nom == null || $m_dossier->nom == ''){
            $m_dossier->nom = $nom;
        }
        $m_dossier->status = $status;
        $m_dossier->mutuelle = $mutuelle;
        $m_dossier->is_deleted = 0;
        $m_dossier->save();
        $m_devis = new Devis();
        $m_devis->dossier = $dossier;
        $m_devis->status = $status;
        $m_devis->mutuelle = $mutuelle;
        $m_devis->date = $date;
        $m_devis->montant = $montant;
        $m_devis->devis_signe = $devis_signe;
        $m_devis->praticien = $praticien;
        $m_devis->observation = $observation;
        $m_devis->id_devis_etat = 1;
        $m_devis->save();
        return $m_devis->id;
    }
    public static function createDevis($dossier, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation)
    {
        // Création d'un nouveau devis
        $devis = new Devis();
        $devis->dossier = $dossier;
        $devis->status = $status;
        $devis->mutuelle = $mutuelle;
        $devis->date = $date;
        $devis->montant = $montant;
        $devis->devis_signe = $devis_signe;
        $devis->praticien = $praticien;
        $devis->observation = $observation;
        $devis->id_devis_etat = 1;

        $devis->save();

        // Retourne l'ID du devis créé
        return $devis->id;
    }

    public static function updateDevis($m_h_devis, $m_devis_etats, $m_devis_ancien, $m_devis_nouveau, &$withChange = false){
        if ($m_devis_ancien->devis_signe != $m_devis_nouveau->devis_signe){
            $m_h_devis->action .= "<strong>Devis signé:</strong> " . $m_devis_ancien->devis_signe . " => " . $m_devis_nouveau->devis_signe . "\n";
            $withChange = true;
        }
        if ($m_devis_ancien->montant != $m_devis_nouveau->montant){
            $m_h_devis->action .= "<strong>Montant:</strong> " . $m_devis_ancien->montant . " => " . $m_devis_nouveau->montant . "\n";
            $withChange = true;
        }
        if ($m_devis_ancien->observation != $m_devis_nouveau->observation){
            $m_h_devis->action .= "<strong>Observation:</strong> " . $m_devis_ancien->observation . " => " . $m_devis_nouveau->observation . "\n";
            $withChange = true;
        }
        if ($m_devis_ancien->id_devis_etat != $m_devis_nouveau->id_devis_etat){
            $etat_ancien = '';
            $etat_nouveau = '';
            foreach ($m_devis_etats as $de){
                if ($de->id == $m_devis_ancien->id_devis_etat) $etat_ancien = $de->etat;
                if ($de->id == $m_devis_nouveau->id_devis_etat) $etat_nouveau = $de->etat;
            }
            $m_h_devis->action .= "<strong>État du devis:</strong> " . $etat_ancien . " => " . $etat_nouveau . "\n";
            $withChange = true;
        }
        $m_devis_nouveau->save();
        return $m_devis_nouveau;
    }

    public function getDate(){
        return Carbon::parse($this->date)->format('d F Y');
    }
}
