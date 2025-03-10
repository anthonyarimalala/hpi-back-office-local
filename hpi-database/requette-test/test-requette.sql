SELECT
    COUNT(pose_statut),
    pose_statut
FROM v_devis
GROUP BY pose_statut;

SELECT
    praticien
FROM ca_actes_reglements
WHERE date_derniere_modif <= ? AND date_derniere_modif >= ?
GROUP BY praticien;
