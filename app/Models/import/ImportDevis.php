<?php

namespace App\Models\import;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDevis extends Model
{
    use HasFactory;
    protected $table = 'import_devis';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'couleur',
        'dossier',
        'id_devis',
        'nom',
        'date_naissance',
        'status',
        'mutuelle',
        'date',
        'montant',
        'devis_signe',
        'praticien',
        'devis_observation',
        'date_envoi_pec',
        'date_fin_validite_pec',
        'part_mutuelle',
        'part_rac',
        'date_paiement_cb_ou_esp',
        'date_depot_chq_pec',
        'date_depot_chq_part_mut',
        'date_depot_chq_rac',
        'date_1er_appel',
        'note_1er_appel',
        'date_2eme_appel',
        'note_2eme_appel',
        'date_3eme_appel',
        'note_3eme_appel',
        'date_envoi_mail',
        'id_devis_etat',
        'etat',
        'couleur',
        'laboratoire',
        'date_empreinte',
        'date_envoi_labo',
        'travail_demande',
        'numero_dent',
        'empreinte_observation',
        'created_at',
        'updated_at',
        'date_livraison',
        'numero_suivi',
        'numero_facture_labo',
        'date_pose_prevue',
        'pose_statut',
        'date_pose_reel',
        'organisme_payeur',
        'montant_encaisse',
        'date_controle_paiement',
        'numero_cheque',
        'montant_cheque',
        'nom_document',
        'date_encaissement_cheque',
        'date_1er_acte',
        'nature_cheque',
        'travaux_sur_devis',
        'situation_cheque',
        'cheque_observation'
    ];

    public function makeDate($date)
    {
        if ($date) {
            $cleanedDate = preg_replace('/[^0-9\-]/', '', $date);
            try {
                return Carbon::parse($cleanedDate)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return $date;
    }
    public function makeDevisSigne($devis_signe)
    {
        $devis_signe = trim($devis_signe);
        if ($devis_signe == null){
            $devis_signe = 'non';
        }
        return strtolower($devis_signe);
    }

}
