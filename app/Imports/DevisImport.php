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
                'date' => $importDevis->makeDate($row[4]),
                'montant' => $row[5],
                'devis_signe' => $importDevis->makeDevisSigne($row[6]),
                'praticien' => $row[7],
                'devis_observation' => $row[8],
                'date_envoi_pec' => $importDevis->makeDate($row[9]),
                'date_fin_validite_pec' => $importDevis->makeDate($row[10]),
                'part_mutuelle' => $row[11],
                'part_rac' => $row[12],
                'date_paiement_cb_ou_esp' => $importDevis->makeDate($row[13]),
                'date_depot_chq_pec' => $importDevis->makeDate($row[14]),
                'date_depot_chq_part_mut' => $importDevis->makeDate($row[15]),
                'date_depot_chq_rac' => $importDevis->makeDate($row[16]),
                'date_1er_appel' => $importDevis->makeDate($row[17]),
                'note_1er_appel' => $row[18],
                'date_2eme_appel' => $importDevis->makeDate($row[19]),
                'note_2eme_appel' => $row[20],
                'date_3eme_appel' => $importDevis->makeDate($row[21]),
                'note_3eme_appel' => $row[22],
                'date_envoi_mail' => $importDevis->makeDate($row[23]),
                'laboratoire' => $row[24],
                'date_empreinte' => $importDevis->makeDate($row[25]),
                'date_envoi_labo' => $importDevis->makeDate($row[26]),
                'travail_demande' => $row[27],
                'numero_dent' => $row[28],
                'empreinte_observation' => $row[29],
                'date_livraison' => $importDevis->makeDate($row[30]),
                'numero_suivi' => $row[31],
                'numero_facture_labo' => $row[32],
                'date_pose_prevue' => $importDevis->makeDate($row[33]),
                'pose_statut' => $row[34],
                'date_pose_reel' => $importDevis->makeDate($row[35]),
                'organisme_payeur' => $row[36],
                'montant_encaisse' => $row[37],
                'date_controle_paiement' => $importDevis->makeDate($row[38]),
                'numero_cheque' => $row[39],
                'montant_cheque' => $row[40],
                'nom_document' => $row[41],
                'date_encaissement_cheque' => $importDevis->makeDate($row[42]),
                'date_1er_acte' => $importDevis->makeDate($row[43]),
                'nature_cheque' => $row[44],
                'travaux_sur_devis' => $row[45],
                'situation_cheque' => $row[46],
                'cheque_observation' => $row[47]
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

