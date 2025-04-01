<?php

namespace App\Models\import;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
        'part_secu',
        'part_secu_status',
        'part_mutuelle',
        'part_mutuelle_status',
        'part_rac',
        'part_rac_status',
        'reglement_cb',
        'reglement_espece',
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


    public function makeNumericOrError($num){
        $formatedNum = trim($num);
        if (is_numeric($formatedNum))
            return $formatedNum;
        else
            throw new Exception('Format du nombre non conforme');
    }
    public function makeDateOrError($date)
    {
        $formattedDate = trim($date);

        // Si la date est une valeur numérique (format Excel)
        if (is_numeric($formattedDate)) {
            return Date::excelToDateTimeObject((float)$formattedDate)->format('Y-m-d');
        }

        // Si la date est au format d/m/Y
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $formattedDate)) {
            $dt = \DateTime::createFromFormat('d/m/Y', $formattedDate);
            if ($dt && $dt->format('d/m/Y') === $formattedDate) {
                // Retourner au format souhaité (ici Y-m-d)
                return $dt->format('Y-m-d');
                // Si vous souhaitez conserver le format d/m/Y, utilisez :
                // return $dt->format('d/m/Y');
            }
        }

        // Sinon, on tente strtotime sur d'autres formats (par ex. YYYY-MM-DD)
        if (strtotime($formattedDate)) {
            return date('Y-m-d', strtotime($formattedDate));
        }

        throw new Exception("Date non conforme : $date");
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
