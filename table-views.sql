DROP VIEW v_patient_dossiers;
CREATE VIEW v_patient_dossiers AS
SELECT
        p.nom,
        p.date_naissance,
        d.dossier,
        d.status
    FROM dossiers d
    JOIN patients p ON d.id_patient = p.id
    WHERE d.is_deleted = 0;

DROP VIEW v_dossiers;
CREATE VIEW v_dossiers AS
SELECT
        d.dossier,
        p.id,
        p.nom,
        p.date_naissance,
        d.status,
        d.updated_at,
        d.is_deleted
    FROM dossiers d
    JOIN patients p ON d.id_patient = p.id;

DROP VIEW v_devis;
CREATE OR REPLACE VIEW v_devis AS
SELECT
    dos.dossier,
    d.id as id_devis,
    d.date,
    d.montant,
    d.devis_signe,
    d.praticien,
    d.observation,
    d.is_deleted,
    d.updated_at AS dernier_modif,
    dap.date_envoi_pec,
    dap.date_fin_validite_pec,
    dap.part_mutuelle,
    dap.part_rac,
    dam.date_1er_appel,
    dam.note_1er_appel,
    dam.date_2eme_appel,
    dam.note_2eme_appel,
    dam.date_3eme_appel,
    dam.note_3eme_appel,
    dam.date_envoi_mail
FROM dossiers dos
LEFT JOIN devis d ON dos.dossier = d.dossier
LEFT JOIN devis_accord_pecs dap ON d.id = dap.id_devis
LEFT JOIN devis_appels_et_mails dam ON d.id = dam.id_devis
LEFT JOIN devis_reglements dr ON d.id = dr.id_devis;


