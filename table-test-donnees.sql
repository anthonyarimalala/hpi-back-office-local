-- v_devis

CREATE OR REPLACE VIEW v_devis AS
SELECT 
    d.dossier,
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
