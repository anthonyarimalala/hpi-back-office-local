<?php
namespace App\Imports;

use App\Models\import\ImportDevis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class DevisImport implements ToModel, WithStartRow
{
    protected $couleurs = [];
    protected $errors = [];
    protected $spreedsheet;
    protected $j = -1;

    public function __construct($path)
    {
        $this->spreedsheet = IOFactory::load($path);
    }

    public function getSpreedsheet(): \PhpOffice\PhpSpreadsheet\Spreadsheet
    {
        return $this->spreedsheet;
    }

    public function model(array $row)
    {
        $importDevis = new ImportDevis();
        $sheet = $this->spreedsheet->getActiveSheet();
        $rowIndex = $this->getRowIndex($row);

        try {
            $i = 1;
            foreach ($row as $columnIndex => $cellValue) {
                if ($i==1) $this->j++;
                $cellCoordinate = Coordinate::stringFromColumnIndex($columnIndex + 1) . $rowIndex + $this->j;
                $cellColor = $sheet->getStyle($cellCoordinate)->getFill()->getStartColor()->getRGB();
                $index = $row[0]."|".$row[4];
                $this->couleurs[$index] = $cellColor;

                $i++;
            }
            // Validation et traitement des données
            return new ImportDevis([
                'couleur' => "#".$this->couleurs[$row[0]."|".$row[4]],
                // 'color' => $firstCellColor,
                'dossier' => $row[0],
                'nom' => $row[1],
                'mutuelle' => $row[2],
                'status' => $row[3],
                'date' => $row[4],
                'montant' => $row[5],
                'devis_signe' => $row[6],
                'praticien' => $row[7],
                'devis_observation' => $row[8],
                'date_envoi_pec' => $row[9],
                'date_fin_validite_pec' => $row[10],
                'part_mutuelle' => $row[11],
                'part_rac' => $row[12],
                'date_paiement_cb_ou_esp' => $row[13],
                'date_depot_chq_pec' => $row[14],
                'date_depot_chq_part_mut' => $row[15],
                'date_depot_chq_rac' => $row[16],
                'date_1er_appel' => $row[17],
                'note_1er_appel' => $row[18],
                'date_2eme_appel' => $row[19],
                'note_2eme_appel' => $row[20],
                'date_3eme_appel' => $row[21],
                'note_3eme_appel' => $row[22],
                'date_envoi_mail' => $row[23],
                'laboratoire' => $row[24],
                'date_empreinte' => $row[25],
                'date_envoi_labo' => $row[26],
                'travail_demande' => $row[27],
                'numero_dent' => $row[28],
                'empreinte_observation' => $row[29],
                'date_livraison' => $row[30],
                'numero_suivi' => $row[31],
                'numero_facture_labo' => $row[32],
                'date_pose_prevue' => $row[33],
                'pose_statut' => $row[34],
                'date_pose_reel' => $row[35],
                'organisme_payeur' => $row[36],
                'montant_encaisse' => $row[37],
                'date_controle_paiement' => $row[38],
                'numero_cheque' => $row[39],
                'montant_cheque' => $row[40],
                'nom_document' => $row[41],
                'date_encaissement_cheque' => $row[42],
                'date_1er_acte' => $row[43],
                'nature_cheque' => $row[44],
                'travaux_sur_devis' => $row[45],
                'situation_cheque' => $row[46],
                'cheque_observation' => $row[47]
            ]);
        } catch (\Exception $e) {
            return null;  // Retourner null si l'import échoue pour cette ligne
        }
    }
    public function onRow(Row $row)
    {
        $this->lineNumber = $row->getIndex();
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
        return 16;  // Définir la première ligne de données
    }
}

