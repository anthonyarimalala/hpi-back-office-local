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
                'part_secu' => $row[11],
                'part_secu_status' => $row[12],
                'part_mutuelle' => $row[13],
                'part_mutuelle_status' => $row[14],
                'part_rac' => $row[15],
                'part_rac_status' => $row[16],
                'reglement_cb' => $row[17],
                'reglement_espece' => $row[18],
                'date_paiement_cb_ou_esp' => $row[19],
                'date_depot_chq_pec' => $row[20],
                'date_depot_chq_part_mut' => $row[21],
                'date_depot_chq_rac' => $row[22],
                'date_1er_appel' => $row[23],
                'note_1er_appel' => $row[24],
                'date_2eme_appel' => $row[25],
                'note_2eme_appel' => $row[26],
                'date_3eme_appel' => $row[27],
                'note_3eme_appel' => $row[28],
                'date_envoi_mail' => $row[29],
                'laboratoire' => $row[30],
                'date_empreinte' => $row[31],
                'date_envoi_labo' => $row[32],
                'travail_demande' => $row[33],
                'numero_dent' => $row[34],
                'empreinte_observation' => $row[35],
                'date_livraison' => $row[36],
                'numero_suivi' => $row[37],
                'numero_facture_labo' => $row[38],
                'date_pose_prevue' => $row[39],
                'pose_statut' => $row[40],
                'date_pose_reel' => $row[41],
                'organisme_payeur' => $row[42],
                'montant_encaisse' => $row[43],
                'date_controle_paiement' => $row[44],
                'numero_cheque' => $row[45],
                'montant_cheque' => $row[46],
                'nom_document' => $row[47],
                'date_encaissement_cheque' => $row[48],
                'date_1er_acte' => $row[49],
                'nature_cheque' => $row[50],
                'travaux_sur_devis' => $row[51],
                'situation_cheque' => $row[52],
                'cheque_observation' => $row[53]

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

