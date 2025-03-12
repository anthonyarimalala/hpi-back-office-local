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


id SERIAL PRIMARY KEY,
date_derniere_modif DATE,
dossier VARCHAR(20) REFERENCES dossiers(dossier),
nom_patient VARCHAR(255),
statut VARCHAR(50),
mutuelle  VARCHAR(255),
praticien VARCHAR(10) REFERENCES praticiens(praticien),
nom_acte VARCHAR(255),
cotation DECIMAL(10, 2),
controle_securisation VARCHAR(255),
ro_part_secu DECIMAL(10, 2),
ro_virement_recu DECIMAL(10, 2),
ro_indus_paye DECIMAL(10, 2),
ro_indus_en_attente DECIMAL(10, 2),
ro_indus_irrecouvrable DECIMAL(10, 2),
part_mutuelle DECIMAL(10, 2),
rcs_virement DECIMAL(10, 2),
rcs_especes DECIMAL(10, 2),
rcs_cb DECIMAL(10, 2),
rcsd_cheque DECIMAL(10, 2),
rcsd_especes DECIMAL(10, 2),
rcsd_cb DECIMAL(10, 2),
rac_part_patient DECIMAL(10, 2),
rac_cheque DECIMAL(10, 2),
rac_especes DECIMAL(10, 2),
rac_cb DECIMAL(10, 2),
commentaire TEXT,
is_deleted INTEGER DEFAULT 0,
created_at TIMESTAMP,
updated_at TIMESTAMP

WITH ca_actes_reglements_bis AS (
    SELECT
        *,
        COALESCE(ro_part_secu, 0) + COALESCE(part_mutuelle, 0) + COALESCE(rac_part_patient, 0) AS cotation_paye,
        COALESCE(ro_virement_recu, 0) + COALESCE(ro_indus_paye, 0) + COALESCE(ro_indus_irrecouvrable, 0) AS ro_part_secu_paye,
        COALESCE(rcs_virement, 0) + COALESCE(rcs_especes, 0) + COALESCE(rcs_cb, 0) + COALESCE(rcsd_cheque, 0) + COALESCE(rcsd_especes, 0) + COALESCE(rcsd_cb, 0) AS part_mutuelle_paye,
        COALESCE(rac_cheque, 0) + COALESCE(rac_especes, 0) + COALESCE(rac_cb, 0) AS rac_part_patient_paye
    FROM ca_actes_reglements
)
SELECT cotation_paye FROM ca_actes_reglements_bis;


SELECT
    *
FROM v_ca_actes_reglements
WHERE cotation_paye > COALESCE(cotation, 0)
OR ro_part_secu_paye > COALESCE(ro_part_secu, 0)
OR part_mutuelle_paye > COALESCE(part_mutuelle, 0)
OR rac_part_patient_paye > COALESCE(rac_part_patient, 0);



WHERE (COALESCE(ro_part_secu, 0)+COALESCE(part_mutuelle, 0)+COALESCE(rac_part_patient, 0)) > cotation
OR COALESCE(ro_part_secu, 0) - (COALESCE(ro_virement_recu, 0)+COALESCE(ro_indus_paye, 0)+COALESCE(ro_indus_irrecouvrable, 0)) < 0
OR COALESCE(part_mutuelle, 0) - (COALESCE(rcs_virement, 0)+COALESCE(rcs_especes, 0)+COALESCE(rcs_cb, 0)+COALESCE(rcsd_cheque, 0)+COALESCE(rcsd_especes, 0)+COALESCE(rcsd_cb, 0)) < 0
OR COALESCE(rac_part_patient, 0) - (COALESCE(rac_cheque, 0)+COALESCE(rac_especes, 0)+COALESCE(rac_cb, 0)) < 0
;

SELECT
    COALESCE(part_mutuelle, 0) - (COALESCE(rcs_virement, 0)+COALESCE(rcs_especes, 0)+COALESCE(rcs_cb, 0)+COALESCE(rcsd_cheque, 0)+COALESCE(rcsd_especes, 0)+COALESCE(rcsd_cb, 0))
FROM ca_actes_reglements WHERE dossier='9320';
