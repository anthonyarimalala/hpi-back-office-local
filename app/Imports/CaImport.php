<?php

namespace App\Imports;

use App\Models\import\ImportCa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CaImport implements ToModel, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new ImportCa([
            'date_derniere_modif' => $row[0],
            'dossier' => $row[1],
            'nom_patient' => $row[2],
            'statut' => $row[3],
            'mutuelle' => $row[4],
            'praticien' => $row[5],
            'nom_acte' => $row[6],
            'cotation' => $row[7],
            'controle_securisation' => $row[8],
            'ro_part_secu' => $row[9],
            'ro_virement_recu' => $row[10],
            'ro_indus_paye' => $row[11],
            'ro_indus_en_attente' => $row[12],
            'ro_indus_irrecouvrable' => $row[13],
            'part_mutuelle' => $row[14],
            'rcs_virement' => $row[15],
            'rcs_especes' => $row[16],
            'rcs_cb' => $row[17],
            'rcsd_cheque' => $row[18],
            'rcsd_especes' => $row[19],
            'rcsd_cb' => $row[20],
            'rac_part_patient' => $row[21],
            'rac_cheque' => $row[22],
            'rac_especes' => $row[23],
            'rac_cb' => $row[24],
            'commentaire' => $row[25],
        ]);
    }
    public function startRow(): int
    {
        return 11;  // Définir la première ligne de données
    }
}
