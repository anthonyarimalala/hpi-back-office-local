<?php

namespace App\Models\import;

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
        'date_devis',
        'patient',
        'mutuelle',
        'patient_c2s',
        'montant',
        'devis_signe',
        'praticien',
        'observation',
        'date_envoi_pec',
        'date_fin_validite_pec',
        'part_secu',
        'part_mutuelle',
        'part_rac',
        'date_paiement_cb_ou_esp',
        'date_depot_chq_pec',
        'date_depot_chq_part_mut',
        'date_depot_chq_rac',
        'date_taille_empreinte',
        'retour_labo',
        'travail_pose',
        'date_1er_appel',
        'note_1er_appel',
        'date_2eme_appel',
        'note_2eme_appel',
        'date_3eme_appel',
        'note_3eme_appel',
        'date_envoi_de_mail',
    ];

}
