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
    FROM ca_actes_reglements
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
FROM sum_calculs;


SELECT
    praticien,
    SUM(cotation) AS sum_cotation_praticien
    FROM ca_actes_reglements
    GROUP BY praticien;


