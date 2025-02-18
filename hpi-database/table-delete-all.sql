DROP VIEW v_ca_actes_reglements;
DROP VIEW v_stat_devis_etats;
DROP VIEW v_stat_devis_mens;
DROP VIEW v_h_devis;
DROP VIEW v_h_protheses;
DROP VIEW v_h_cheques;
DROP VIEW v_protheses;
DROP VIEW v_cheques;
DROP VIEW v_devis;


DELETE FROM h_autres;
DELETE FROM h_cheques;
DELETE FROM h_devis;
DELETE FROM h_protheses;
DELETE FROM h_ca_actes_reglements;
DELETE FROM prothese_travaux;
DELETE FROM prothese_retour_labos;
DELETE FROM prothese_empreintes;
DELETE FROM info_cheques;
DELETE FROM devis_appels_et_mails;
DELETE FROM devis_reglements;
DELETE FROM devis_accord_pecs;
DELETE FROM devis;
DELETE FROM ca_actes_reglements;
DELETE FROM dossiers;


DROP TABLE import_devis;
DROP TABLE import_ca_actes_reglements;
DROP TABLE h_autres;
DROP TABLE h_ca_actes_reglements;
DROP TABLE h_cheques;
DROP TABLE h_devis;
DROP TABLE h_protheses;
DROP TABLE ca_actes_reglements;
DROP TABLE prothese_travaux;
DROP TABLE prothese_travaux_status;
DROP TABLE prothese_retour_labos;
DROP TABLE prothese_empreintes;
DROP TABLE info_cheques;
DROP TABLE info_cheques_nature_cheques;
DROP TABLE info_cheques_travaux_sur_devis;
DROP TABLE info_cheques_situation_cheques;
DROP TABLE devis_appels_et_mails;
DROP TABLE devis_reglements;
DROP TABLE devis_accord_pecs;
DROP TABLE devis;
DROP TABLE devis_etats;
DROP TABLE dossiers;
DROP TABLE praticiens;
DROP TABLE dossier_statuss;

