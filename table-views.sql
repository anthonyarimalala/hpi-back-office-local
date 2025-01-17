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
    d.id AS id_devis,
    pat.nom,
    pat.date_naissance,
    dos.status,
    d.date,
    d.montant,
    d.devis_signe,
    d.praticien,
    d.observation AS devis_observation,
    d.is_deleted,
    d.updated_at AS dernier_modif,
    dap.date_envoi_pec,
    dap.date_fin_validite_pec,
    dap.part_mutuelle,
    dap.part_rac,
    dr.date_paiement_cb_ou_esp,
    dr.date_depot_chq_pec,
    dr.date_depot_chq_part_mut,
    dr.date_depot_chq_rac,
    dam.date_1er_appel,
    dam.note_1er_appel,
    dam.date_2eme_appel,
    dam.note_2eme_appel,
    dam.date_3eme_appel,
    dam.note_3eme_appel,
    dam.date_envoi_mail,
    de.etat,
    de.couleur,
    emp.laboratoire,
    emp.date_empreinte,
    emp.date_envoi_labo,
    emp.travail_demande,
    emp.numero_dent,
    emp.observations AS empreinte_observation,
    emp.created_at,
    emp.updated_at,
    rl.date_livraison,
    rl.numero_suivi,
    rl.numero_facture_labo,
    tra.date_pose_prevue,
    tra.statut AS pose_statut,
    tra.date_pose_reel,
    tra.organisme_payeur,
    tra.montant_encaisse,
    tra.date_controle_paiement,
    ic.numero_cheque,
    ic.montant_cheque,
    ic.nom_document,
    ic.date_encaissement_cheque,
    ic.date_1er_acte   ,
    ic.nature_cheque,
    ic.travaux_sur_devis,
    ic.situation_cheque,
    ic.observation AS cheque_observation
FROM devis d
         JOIN dossiers dos ON d.dossier = dos.dossier
         JOIN patients pat ON dos.id_patient = pat.id
         LEFT JOIN devis_accord_pecs dap ON d.id = dap.id_devis
         LEFT JOIN devis_appels_et_mails dam ON d.id = dam.id_devis
         LEFT JOIN devis_reglements dr ON d.id = dr.id_devis
         LEFT JOIN devis_etats de ON d.devis_etat = de.etat
         LEFT JOIN prothese_empreintes emp ON d.id = emp.id_devis
         LEFT JOIN prothese_retour_labos rl ON d.id = rl.id_devis
         LEFT JOIN prothese_travaux tra ON d.id = tra.id_devis
         LEFT JOIN info_cheques ic ON d.id = ic.id_devis;


CREATE OR REPLACE VIEW v_cheques AS
SELECT
    d.dossier,
    d.id AS id_devis,
    ic.id AS id_info_cheques,
    ic.numero_cheque ,
    ic.montant_cheque ,
    ic.nom_document ,
    ic.date_encaissement_cheque ,
    ic.date_1er_acte ,
    ic.nature_cheque ,
    ic.travaux_sur_devis ,
    ic.situation_cheque ,
    ic.observation ,
    ic.created_at ,
    ic.updated_at
FROM devis d
        LEFT JOIN info_cheques ic ON d.id = ic.id_devis;

DROP VIEW v_protheses;
CREATE VIEW v_protheses as
SELECT
    dev.dossier,
    dev.id as id_devis,
    emp.laboratoire,
    emp.date_empreinte,
    emp.date_envoi_labo,
    emp.travail_demande,
    emp.numero_dent,
    emp.observations,
    emp.created_at,
    emp.updated_at,
    rl.date_livraison,
    rl.numero_suivi,
    rl.numero_facture_labo,
    tra.date_pose_prevue,
    tra.statut,
    tra.date_pose_reel,
    tra.organisme_payeur,
    tra.montant_encaisse,
    tra.date_controle_paiement
FROM
    devis dev
        LEFT JOIN prothese_empreintes emp ON dev.id = emp.id_devis
        LEFT JOIN prothese_retour_labos rl ON dev.id = rl.id_devis
        LEFT JOIN prothese_travaux tra ON dev.id = tra.id_devis;

