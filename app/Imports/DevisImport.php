<?php
namespace App\Imports;

use App\Models\import\ImportDevis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class DevisImport implements ToModel, WithStartRow
{
    protected $errors = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Validation et traitement des données
            return new ImportDevis([
                'dossier' => $row[0],
                'date_devis' => is_numeric($row[1]) ? Date::excelToDateTimeObject($row[1])->format('Y-m-d') : null,
                'patient' => $row[2],
                'mutuelle' => $row[3],
                'patient_c2s' => $row[4],
                'montant' => $row[5],
                'devis_signe' => $row[6],
                'praticien' => $row[7],
                'date_envoi_pec' => is_numeric($row[9]) ? Date::excelToDateTimeObject($row[9])->format('Y-m-d') : null,
                'date_fin_validite_pec' => is_numeric($row[10]) ? Date::excelToDateTimeObject($row[10])->format('Y-m-d') : null,
                'part_secu' => $row[11],
                'part_mutuelle' => $row[12],
                'part_rac' => floatval($row[13]),
                'date_paiement_cb_ou_esp' => is_numeric($row[16]) ? Date::excelToDateTimeObject($row[16])->format('Y-m-d') : null,
                'date_depot_chq_pec' => is_numeric($row[17]) ? Date::excelToDateTimeObject($row[17])->format('Y-m-d') : null,
                'date_depot_chq_part_mut' => is_numeric($row[18]) ? Date::excelToDateTimeObject($row[18])->format('Y-m-d') : null,
                'date_depot_chq_rac' => is_numeric($row[19]) ? Date::excelToDateTimeObject($row[19])->format('Y-m-d') : null,
                'date_taille_empreinte' => is_numeric($row[20]) ? Date::excelToDateTimeObject($row[20])->format('Y-m-d') : null,
                'retour_labo' => $row[21],
                'travail_pose' => $row[22],
                'date_1er_appel' => is_numeric($row[23]) ? Date::excelToDateTimeObject($row[23])->format('Y-m-d') : null,
                'note_1er_appel' => $row[24],
                'date_2eme_appel' => is_numeric($row[25]) ? Date::excelToDateTimeObject($row[25])->format('Y-m-d') : null,
                'note_2eme_appel' => $row[26],
                'date_3eme_appel' => is_numeric($row[27]) ? Date::excelToDateTimeObject($row[27])->format('Y-m-d') : null,
                'note_3eme_appel' => $row[28],
                'date_envoi_de_mail' => is_numeric($row[29]) ? Date::excelToDateTimeObject($row[29])->format('Y-m-d') : null,
            ]);
        } catch (\Exception $e) {
            // Stocker l'erreur et la ligne
            $this->errors[] = [
                'line' => $this->getRowIndex(),  // Numéro de ligne
                'errors' => $e->getMessage(),    // Message d'erreur
            ];
            return null;  // Retourner null si l'import échoue pour cette ligne
        }
    }

    /**
     * Récupérer le numéro de la ligne actuelle (commence à 1).
     */
    public function getRowIndex(): int
    {
        // Calculer l'index de la ligne dans le fichier Excel
        return $this->startRow();
    }

    /**
     * Retourner les erreurs accumulées
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function startRow(): int
    {
        return 13;  // Définir la première ligne de données
    }
}

