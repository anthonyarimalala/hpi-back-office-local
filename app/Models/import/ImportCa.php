<?php

namespace App\Models\import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mockery\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportCa extends Model
{
    use HasFactory;
    protected $table = 'import_ca_actes_reglements';
    protected $fillable = [
        'date_derniere_modif',
        'dossier',
        'nom_patient',
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
        if (is_numeric($date))
            $formattedDate = str_replace("/", "-", $formattedDate);
        else
            throw new Exception("Date non conforme");
        return Date::excelToDateTimeObject((float) $formattedDate)->format('Y-m-d');
    }
    public function makeDate($date)
    {
        $date = trim($date);
        if ($date && $date!='') {
            $cleanedDate = preg_replace('/[^0-9\/\-]/', '', $date);
            $formattedDate = str_replace("/", "-", $cleanedDate);
            if (Str::contains($formattedDate, '-')){
                $nouvelleDate = $formattedDate;
            }
            else{
                $nouvelleDate = Date::excelToDateTimeObject((float) $formattedDate)->format('Y-m-d');
            }
            try {
                return $nouvelleDate;
            } catch (\Exception $e) {
                return null;
            }
        }
        return null ;
    }
}
