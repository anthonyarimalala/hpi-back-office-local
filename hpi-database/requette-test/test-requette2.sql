DELETE FROM info_cheques WHERE created_at > '2025-06-05 13:48:02' AND created_at < '2025-06-05 13:48:09';
DELETE FROM devis_appels_et_mails WHERE created_at >= '2025-06-05 13:48:03' AND created_at <= '2025-06-05 13:48:07';
DELETE FROM devis_reglements WHERE created_at >= '2025-06-05 13:48:03' AND created_at <= '2025-06-05 13:48:07';
DELETE FROM devis_accord_pecs WHERE created_at >= '2025-06-05 13:48:03' AND created_at <= '2025-06-05 13:48:07';
DELETE FROM l_ca_actes_reglements WHERE created_at > '2025-06-05 12:27:56' AND created_at < '2025-06-05 12:28:01';
DELETE FROM ca_generales WHERE created_at > '2025-06-05 12:27:56' AND created_at < '2025-06-05 12:28:01';
DELETE FROM protheses WHERE created_at >= '2025-06-05 13:48:03' AND created_at <= '2025-06-05 13:48:07';
DELETE FROM devis WHERE created_at >= '2025-06-05 13:48:03' AND created_at <= '2025-06-05 13:48:08';
DELETE FROM dossiers WHERE created_at >= '2025-06-05 12:27:58' AND created_at <= '2025-06-05 12:28:00';



DELETE FROM protheses WHERE id_devis = '419';
DELETE FROM info_cheques WHERE id_devis = '419';
DELETE FROM devis_appels_et_mails WHERE id_devis = '419';
DELETE FROM devis_reglements WHERE id_devis = '419';
DELETE FROM devis_accord_pecs WHERE id_devis = '419';
DELETE FROM l_ca_actes_reglements WHERE id_devis = '419';
DELETE FROM ca_generales WHERE id_devis = '419';
DELETE FROM devis WHERE id = '419';
DELETE FROM dossiers WHERE dossier = '3354';


INSERT INTO users( code_u, nom, prenom, email, role, password) VALUES('U0001', 'Johary', 'Anthony','U0001@gmail.com', 'admin', '$2y$10$lRjPhSO2INm4MLdIEpYyMu0u4LHFKNEXDUpkxIsTiChGWJu6oeEnu');
