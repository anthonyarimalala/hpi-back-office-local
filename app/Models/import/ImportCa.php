<?php

namespace App\Models\import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportCa extends Model
{
    use HasFactory;
    protected $table = 'import_ca_actes_reglements';
    protected $fillable = [
        'date_derniere_modif',
        'dossier',
        'statut',
        'mutuelle',
        'praticien',
        'nom_acte',
        'cotation',
        'controle_securisation',
        'ro_part_secu',
        'ro_virement_recu',
        'ro_indus_paye',
        'ro_indus_en_attente',
        'ro_indus_irrecouvrable',
        'part_mutuelle',
        'rcs_virement',
        'rcs_especes',
        'rcs_cb',
        'rcsd_cheque',
        'rcsd_especes',
        'rcsd_cb',
        'rac_part_patient',
        'rac_cheque',
        'rac_especes',
        'rac_cb',
        'commentaire',
    ];

}
