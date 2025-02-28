SELECT
    COUNT(pose_statut),
    pose_statut
FROM v_devis
GROUP BY pose_statut;
