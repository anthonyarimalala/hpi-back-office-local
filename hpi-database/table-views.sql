CREATE OR REPLACE VIEW v_devis AS
SELECT
    dos.dossier,
    d.id AS id_devis,
    dos.nom,
    dos.date_naissance,
    dos.email,
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
    dap.part_secu,
    dap.part_secu_status,
    dap.part_mutuelle,
    dap.part_mutuelle_status,
    dap.part_rac,
    dap.part_rac_status,
    dr.reglement_cb,
    dr.reglement_espece,
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
    dam.email_sent,
    de.id AS id_devis_etat,
    de.etat,
    de.couleur,
    emp.id AS id_acte,
    emp.laboratoire,
    emp.date_empreinte,
    emp.date_envoi_labo,
    emp.travail_demande,
    emp.montant_acte,
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
    (COALESCE(emp.montant_acte, 0) - COALESCE(tra.montant_encaisse, 0)) AS reste_a_payer,
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
         LEFT JOIN prothese_retour_labos rl ON emp.id = rl.id_acte
         LEFT JOIN prothese_travaux tra ON emp.id = tra.id_acte
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

CREATE VIEW v_protheses as
SELECT
    dev.dossier,
    dev.id AS id_devis,
    emp.id AS id_acte,
    emp.laboratoire,
    emp.date_empreinte,
    emp.date_envoi_labo,
    emp.travail_demande,
    emp.montant_acte,
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
    tra.date_controle_paiement,
    (COALESCE(emp.montant_acte, 0) - COALESCE(tra.montant_encaisse, 0)) AS reste_a_payer
FROM
    devis dev
        LEFT JOIN prothese_empreintes emp ON dev.id = emp.id_devis
        LEFT JOIN prothese_retour_labos rl ON emp.id = rl.id_acte
        LEFT JOIN prothese_travaux tra ON emp.id = tra.id_acte
        LEFT JOIN prothese_travaux_status pts ON tra.id_pose_statut = pts.id;

CREATE OR REPLACE VIEW v_ca_actes_reglements AS
SELECT
    lcar.id ,
    cg.id AS id_ca,
    cg.dossier ,
    cg.nom_patient ,
    cg.statut ,
    cg.mutuelle ,
    lcar.id AS id_ca_actes_reglement,
    lcar.praticien ,
    lcar.date_derniere_modif ,
    lcar.nom_acte ,
    lcar.cotation ,
    lcar.controle_securisation ,
    lcar.ro_part_secu ,
    lcar.ro_virement_recu ,
    lcar.ro_indus_paye ,
    lcar.ro_indus_en_attente ,
    lcar.ro_indus_irrecouvrable ,
    lcar.part_mutuelle ,
    lcar.rcs_virement ,
    lcar.rcs_especes ,
    lcar.rcs_cb ,
    lcar.rcsd_cheque ,
    lcar.rcsd_especes ,
    lcar.rcsd_cb ,
    lcar.rac_part_patient ,
    lcar.rac_cheque ,
    lcar.rac_especes ,
    lcar.rac_cb ,
    lcar.commentaire ,
    lcar.created_at ,
    lcar.updated_at ,
    dos.nom,
    dos.date_naissance,
    COALESCE(ro_part_secu, 0) + COALESCE(part_mutuelle, 0) + COALESCE(rac_part_patient, 0) AS cotation_paye,
    COALESCE(ro_virement_recu, 0) + COALESCE(ro_indus_paye, 0) + COALESCE(ro_indus_irrecouvrable, 0) AS ro_part_secu_paye,
    COALESCE(rcs_virement, 0) + COALESCE(rcs_especes, 0) + COALESCE(rcs_cb, 0) + COALESCE(rcsd_cheque, 0) + COALESCE(rcsd_especes, 0) + COALESCE(rcsd_cb, 0) AS part_mutuelle_paye,
    COALESCE(rac_cheque, 0) + COALESCE(rac_especes, 0) + COALESCE(rac_cb, 0) AS rac_part_patient_paye,
    lcar.is_deleted
        FROM ca_generales cg
        JOIN l_ca_actes_reglements lcar ON cg.id = lcar.id_ca
        JOIN dossiers dos ON cg.dossier = dos.dossier;
