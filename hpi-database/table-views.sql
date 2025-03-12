

CREATE OR REPLACE VIEW v_h_devis AS
SELECT
    hd.code_u,
    usr.nom,
    usr.prenom,
    hd.id_devis,
    dos.dossier,
    hd.action,
    hd.created_at
FROM h_devis hd
JOIN devis dev ON hd.id_devis = dev.id
JOIN dossiers dos ON dev.dossier = dos.dossier
JOIN users usr ON hd.code_u = usr.code_u;

CREATE OR REPLACE VIEW v_h_protheses AS
SELECT
    hp.code_u,
    usr.nom,
    usr.prenom,
    hp.id_devis,
    dos.dossier,
    hp.action,
    hp.created_at
FROM h_protheses hp
JOIN devis dev ON hp.id_devis = dev.id
JOIN dossiers dos ON dev.dossier = dos.dossier
JOIN users usr ON hp.code_u = usr.code_u;

CREATE OR REPLACE VIEW v_h_cheques AS
SELECT
    hc.code_u,
    usr.nom,
    usr.prenom,
    hc.id_devis,
    dos.dossier,
    hc.action,
    hc.created_at
FROM h_cheques hc
JOIN devis dev ON hc.id_devis = dev.id
JOIN dossiers dos ON dev.dossier = dos.dossier
JOIN users usr ON hc.code_u = usr.code_u;

CREATE OR REPLACE VIEW v_devis AS
SELECT
    dos.dossier,
    d.id AS id_devis,
    dos.nom,
    dos.date_naissance,
    d.status,
    d.mutuelle,
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
    de.id AS id_devis_etat,
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
    pts.id AS id_pose_statut,
    pts.travaux_status AS pose_statut,
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
         LEFT JOIN devis_accord_pecs dap ON d.id = dap.id_devis
         LEFT JOIN devis_appels_et_mails dam ON d.id = dam.id_devis
         LEFT JOIN devis_reglements dr ON d.id = dr.id_devis
         LEFT JOIN devis_etats de ON d.id_devis_etat = de.id
         LEFT JOIN prothese_empreintes emp ON d.id = emp.id_devis
         LEFT JOIN prothese_retour_labos rl ON d.id = rl.id_devis
         LEFT JOIN prothese_travaux tra ON d.id = tra.id_devis
         LEFT JOIN info_cheques ic ON d.id = ic.id_devis
         LEFT JOIN prothese_travaux_status pts ON tra.id_pose_statut = pts.id;

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
    pts.id AS id_pose_statut,
    pts.travaux_status AS statut,
    tra.date_pose_reel,
    tra.organisme_payeur,
    tra.montant_encaisse,
    tra.date_controle_paiement
FROM
    devis dev
        LEFT JOIN prothese_empreintes emp ON dev.id = emp.id_devis
        LEFT JOIN prothese_retour_labos rl ON dev.id = rl.id_devis
        LEFT JOIN prothese_travaux tra ON dev.id = tra.id_devis
       LEFT JOIN prothese_travaux_status pts ON tra.id_pose_statut = pts.id;

CREATE OR REPLACE VIEW v_ca_actes_reglements AS
SELECT
    car.*,
    dos.nom,
    dos.date_naissance,
    COALESCE(ro_part_secu, 0) + COALESCE(part_mutuelle, 0) + COALESCE(rac_part_patient, 0) AS cotation_paye,
    COALESCE(ro_virement_recu, 0) + COALESCE(ro_indus_paye, 0) + COALESCE(ro_indus_irrecouvrable, 0) AS ro_part_secu_paye,
    COALESCE(rcs_virement, 0) + COALESCE(rcs_especes, 0) + COALESCE(rcs_cb, 0) + COALESCE(rcsd_cheque, 0) + COALESCE(rcsd_especes, 0) + COALESCE(rcsd_cb, 0) AS part_mutuelle_paye,
    COALESCE(rac_cheque, 0) + COALESCE(rac_especes, 0) + COALESCE(rac_cb, 0) AS rac_part_patient_paye
        FROM ca_actes_reglements car
        JOIN dossiers dos ON car.dossier = dos.dossier;



