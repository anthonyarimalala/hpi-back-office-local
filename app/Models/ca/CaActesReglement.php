<?php

namespace App\Models\ca;

use App\Models\dossier\Dossier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CaActesReglement extends Model
{
    use HasFactory;
    protected $table = 'ca_actes_reglements';

    // O raha mbola tsy misy, 1 raha efa misy
    public static function saveCa(Request $request, $action, $id_ca=null)
    {
        // Récupérer les données du formulaire
        $dossier = $request->input('dossiers');
        $m_dossier = Dossier::where('dossier', $dossier)->first();
        if(!$m_dossier) return back()->withErrors('Le dossier "' . $dossier . '" n\'existe pas.');
        $date_derniere_modif = $request->input('date_derniere_modif');
        if (!$date_derniere_modif) $date_derniere_modif = Carbon::parse()->format('Y-m-d');
        $statut = $request->input('statut');
        $mutuelle = $request->input('mutuelle');

        // Pour les actes
        $praticien = $request->input('praticien');
        $nom_acte = $request->input('nom_acte');
        $cotation = $request->input('cotation');
        $controle_securisation = $request->input('controle_securisation');

        // Pour les RO (Remboursement d'Ordre)
        $ro_part_secu = $request->input('ro_part_secu');
        $ro_virement_recu = $request->input('ro_virement_recu');
        $ro_indus_paye = $request->input('ro_indus_paye');
        $ro_indus_en_attente = $request->input('ro_indus_en_attente');
        $ro_indus_irrecouvrable = $request->input('ro_indus_irrecouvrable');

        // Pour la part mutuelle
        $part_mutuelle = $request->input('part_mutuelle');

        // Pour les RC Soins
        $rcs_virement = $request->input('rcs_virement');
        $rcs_especes = $request->input('rcs_especes');
        $rcs_cb = $request->input('rcs_cb');

        // Pour les RC Soins avec devis
        $rcsd_cheque = $request->input('rcsd_cheque');
        $rcsd_especes = $request->input('rcsd_especes');
        $rcsb_cb = $request->input('rcsb_cb');

        // Pour la RAC
        $rac_part_patient = $request->input('rac_part_patient');
        $rac_cheque = $request->input('rac_cheque');
        $rac_especes = $request->input('rac_especes');
        $rac_cb = $request->input('rac_cb');

        // Commentaire
        $commentaire = $request->input('commentaire');

        if ($action == 0){
            $m_ca_acte_reglement = new CaActesReglement();
            $m_ca_acte_reglement->dossier = $dossier;
        }
        elseif ($action == 1){
            $m_ca_acte_reglement = CaActesReglement::firstOrNew(['id'=>$id_ca, 'dossier'=>$dossier]);
        }


        // Attribuer les valeurs récupérées aux colonnes correspondantes dans le modèle
        $m_ca_acte_reglement->date_derniere_modif = $date_derniere_modif;
        $m_ca_acte_reglement->statut = $statut;
        $m_ca_acte_reglement->mutuelle = $mutuelle;

        // Actes
        $m_ca_acte_reglement->praticien = $praticien;
        $m_ca_acte_reglement->nom_acte = $nom_acte;
        $m_ca_acte_reglement->cotation = $cotation;
        $m_ca_acte_reglement->controle_securisation = $controle_securisation;

        // RO
        $m_ca_acte_reglement->ro_part_secu = $ro_part_secu;
        $m_ca_acte_reglement->ro_virement_recu = $ro_virement_recu;
        $m_ca_acte_reglement->ro_indus_paye = $ro_indus_paye;
        $m_ca_acte_reglement->ro_indus_en_attente = $ro_indus_en_attente;
        $m_ca_acte_reglement->ro_indus_irrecouvrable = $ro_indus_irrecouvrable;

        // Part Mutuelle
        $m_ca_acte_reglement->part_mutuelle = $part_mutuelle;

        // RC Soins
        $m_ca_acte_reglement->rcs_virement = $rcs_virement;
        $m_ca_acte_reglement->rcs_especes = $rcs_especes;
        $m_ca_acte_reglement->rcs_cb = $rcs_cb;

        // RC Soins avec devis
        $m_ca_acte_reglement->rcsd_cheque = $rcsd_cheque;
        $m_ca_acte_reglement->rcsd_especes = $rcsd_especes;
        $m_ca_acte_reglement->rcsb_cb = $rcsb_cb;

        // RAC
        $m_ca_acte_reglement->rac_part_patient = $rac_part_patient;
        $m_ca_acte_reglement->rac_cheque = $rac_cheque;
        $m_ca_acte_reglement->rac_especes = $rac_especes;
        $m_ca_acte_reglement->rac_cb = $rac_cb;

        // Commentaire
        $m_ca_acte_reglement->commentaire = $commentaire;

        // Sauvegarder les données
        $m_ca_acte_reglement->save();

        // Retourner une réponse ou rediriger selon ton besoin
        return $m_ca_acte_reglement;
    }

}
