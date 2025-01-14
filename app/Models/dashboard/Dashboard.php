<?php

namespace App\Models\dashboard;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;
    public function getAppelsAujourdHui(){
        $appels = DB::select(
            "
            SELECT *
                FROM (
                    SELECT
                        id_devis,
                        date_1er_appel AS date_appel,
                        1 AS numero_ap,
                        '1er appel' AS numero_appel,
                        note_1er_appel AS note_appel
                    FROM devis_appels_et_mails
                    WHERE date_1er_appel IS NOT NULL
                    UNION ALL
                    SELECT
                        id_devis,
                        date_2eme_appel AS date_appel,
                        2 AS numero_ap,
                        '2ème appel' AS numero_appel,
                        note_2eme_appel AS note_appel
                    FROM devis_appels_et_mails
                    WHERE date_2eme_appel IS NOT NULL
                    UNION ALL
                    SELECT
                        id_devis,
                        date_3eme_appel AS date_appel,
                        3 AS numero_ap,
                        '3ème appel' AS numero_appel,
                        note_3eme_appel AS note_appel
                    FROM devis_appels_et_mails
                    WHERE date_3eme_appel IS NOT NULL
                    ORDER BY id_devis, numero_appel
                ) AS appels_mails
                JOIN devis ON appels_mails.id_devis = devis.id
                JOIN dossiers ON devis.dossier = dossiers.dossier
                JOIN patients ON patients.id = dossiers.id_patient
                WHERE appels_mails.date_appel::date = CURRENT_DATE;
                            "
                        );
        return $appels;
    }
}
