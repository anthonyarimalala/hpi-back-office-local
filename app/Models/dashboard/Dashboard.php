<?php

namespace App\Models\dashboard;

use App\Models\views\V_Devis;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;

    public function getCaPraticiens($date_ca_debut, $date_ca_fin)
    {
        $datas = DB::select("
            SELECT
                praticien,
                SUM(cotation) AS sum_cotation_praticien,
                SUM(COALESCE(ro_part_secu_paye, 0)+COALESCE(part_mutuelle_paye, 0)+COALESCE(rac_part_patient_paye, 0)) AS sum_cotation_praticien_reste_a_paye
            FROM v_ca_actes_reglements
            WHERE created_at >= ? AND created_at <= ?
            GROUP BY praticien
        ", [$date_ca_debut.' 00:00:00', $date_ca_fin.' 23:59:59']);
        return $datas;
    }
    public function getCaBilanFincancier($date_ca_debut, $date_ca_fin)
    {
        $datas = DB::select("
            WITH sum_calculs AS (
                SELECT
                    COALESCE(SUM(COALESCE(ro_part_secu, 0)), 0) AS sum_ro_part_secu,
                    COALESCE(SUM(COALESCE(part_mutuelle, 0)), 0) AS sum_part_mutuelle,
                    COALESCE(SUM(COALESCE(rac_part_patient, 0)), 0) AS sum_rac_part_patient,
                    COALESCE(SUM(COALESCE(ro_virement_recu, 0)), 0) AS sum_ro_virement_recu,
                    COALESCE(SUM(COALESCE(ro_indus_paye, 0)), 0) AS sum_ro_indus_paye,
                    COALESCE(SUM(COALESCE(ro_indus_irrecouvrable, 0)), 0) AS sum_ro_indus_irrecouvrable,
                    COALESCE(SUM(COALESCE(rcs_virement, 0) + COALESCE(rcs_especes, 0) + COALESCE(rcs_cb, 0) + COALESCE(rcsd_cheque, 0) + COALESCE(rcsd_especes, 0) + COALESCE(rcsd_cb, 0)), 0) AS sum_rcs_rcsd,
                    COALESCE(SUM(COALESCE(rac_part_patient, 0)), 0) AS sum_part_patient,
                    COALESCE(SUM(COALESCE(rac_cheque, 0) + COALESCE(rac_especes, 0) + COALESCE(rac_cb, 0)), 0) AS sum_rac_wt_part_patient,
                    COALESCE(SUM(COALESCE(ro_indus_en_attente, 0)), 0) AS sum_ro_indus_en_attente
                FROM v_ca_actes_reglements
                WHERE created_at >= ? AND created_at <= ?
            )
            SELECT
                sum_ro_part_secu AS total_total_part_secu,
                sum_part_mutuelle AS total_total_part_mut,
                sum_rac_part_patient AS total_total_part_patient,
                (sum_ro_part_secu - sum_ro_virement_recu - sum_ro_indus_paye - sum_ro_indus_irrecouvrable) AS virement_en_attente_total_part_secu,
                (sum_part_mutuelle - sum_rcs_rcsd) AS virement_en_attente_total_part_mut,
                (sum_rac_part_patient - sum_rac_wt_part_patient) AS virement_en_attente_total_part_patient,
                sum_ro_indus_paye AS indus_paye_total_part_secu,
                sum_ro_indus_en_attente AS indus_en_attente_total_part_secu,
                sum_ro_indus_irrecouvrable AS indus_irrecouvrable_total_part_secu,
                (sum_ro_virement_recu + sum_ro_indus_paye + sum_rcs_rcsd + sum_rac_wt_part_patient) AS virement_recu_en_compte,
                (sum_ro_part_secu + sum_part_mutuelle + sum_rac_part_patient) AS ca_global,
                CASE
                    WHEN (sum_ro_part_secu + sum_part_mutuelle + sum_rac_part_patient) = 0 THEN 0
                    ELSE ((sum_ro_virement_recu + sum_ro_indus_paye + sum_rcs_rcsd + sum_rac_wt_part_patient) * 100) / (sum_ro_part_secu + sum_part_mutuelle + sum_rac_part_patient)
                    END AS taux_encaissement
            FROM sum_calculs
        ", [$date_ca_debut.' 00:00:00', $date_ca_fin.' 23:59:59']);
        return $datas[0];
    }
    public function getTotalPoseStatus($date_debut, $date_fin){
        $total = DB::select("
            SELECT
                COUNT(pose_statut) AS nbr_pose_status,
                pose_statut
            FROM v_devis
            WHERE date >= ? AND date <= ?
            GROUP BY pose_statut;
        ", [$date_debut, $date_fin]);
        return $total;
    }
    public function getTotalDevisEtats($date_debut, $date_fin)
    {
        $total = DB::select("
            SELECT
                COALESCE(COUNT(d.id), 0) AS nbr_devis,
                de.etat,
                de.couleur,
                de.id
            FROM devis d
            JOIN devis_etats de ON d.id_devis_etat = de.id
            WHERE date >= ? AND date <= ?
            GROUP BY de.id, de.etat, de.couleur
        ", [$date_debut, $date_fin]);
        return $total;
    }
    public function getTotalDevisSigne($date_debut, $date_fin){
        $total = DB::select("
        SELECT
            COUNT(id_devis) AS nbr_devis,
            COUNT(CASE WHEN devis_signe = 'oui' THEN 1 END) AS nbr_devis_signe,
            COUNT(CASE WHEN devis_signe = 'non' THEN 1 END) AS nbr_devis_non_signe
        FROM v_devis
        WHERE date >= ? AND date <= ?
        ", [$date_debut, $date_fin]);
        return $total[0];
    }


    public function getReglementsAujourdHui()
    {
        $today = Carbon::today()->format('Y-m-d');
        $rappels = V_Devis::where('date_paiement_cb_ou_esp', $today)
            ->orWhere('date_depot_chq_pec', $today)
            ->orWhere('date_depot_chq_part_mut', $today)
            ->orWhere('date_depot_chq_rac', $today)
            ->where('devis_signe', 'oui')
            ->all();
        return $rappels;
    }

    public function getAppelsMailsAujourdHui(){
        $today = Carbon::today()->format('Y-m-d');
        $appels = V_Devis::where('date_1er_appel', $today)
            ->orWhere('date_2eme_appel', $today)
            ->orWhere('date_3eme_appel', $today)
            ->orWhere('date_envoi_mail', $today)
            ->get();
        return $appels;
    }

}
