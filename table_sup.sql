
-- DEBUT: clés primaires
CREATE TABLE dossier_statuss(
    status VARCHAR(10) PRIMARY KEY,
    signification VARCHAR(255),
    ordre INTEGER
);

CREATE TABLE praticiens(
    praticien VARCHAR(10) PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE pose_statuss(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(255)
);

CREATE TABLE cheque_natures(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(20)
);

CREATE TABLE cheque_situations(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(20)
);
-- FIN: clés primaires

CREATE TABLE patients(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    date_naissance DATE,
);

CREATE TABLE dossiers(
    numero VARCHAR(20) PRIMARY KEY,
    id_patient INTEGER REFERENCES patients(id),
    status VARCHAR(10) REFERENCES dossier_statuss(status)
);

CREATE TABLE l_dossier_mutuelles(
    id SERIAL PRIMARY KEY,
    numero_dossier VARCHAR(20) REFERENCES dossiers(numero),
    mutuelle VARCHAR(20)
);

CREATE TABLE devis(
    id SERIAL PRIMARY KEY,
    numero_dossier VARCHAR(20) REFERENCES dossiers(numero),
    date TIMESTAMP,
    montant FLOAT,
    devis_signe VARCHAR(3),
    praticien VARCHAR(10) REFERENCES praticiens(praticien),
    observation TEXT
);

CREATE TABLE devis_accord_pecs(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_envoi_pec TIMESTAMP,
    date_fin_validite_pec TIMESTAMP,
    part_mutuelle FLOAT,
    part_rac FLOAT
);

CREATE TABLE devis_reglements(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_paiement_cb_ou_esp TIMESTAMP,
    date_depot_chq_pec TIMESTAMP,
    date_depot_chq_part_mut TIMESTAMP,
    date_depot_chq_rac TIMESTAMP
);

CREATE TABLE devis_appels_et_mails(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_1er_appel TIMESTAMP,
    note_1er_appel TEXT,
    date_2eme_appel TIMESTAMP,
    note_2eme_appel TEXT,
    date_3eme_appel TIMESTAMP,
    note_3eme_appel TEXT,
    date_envoi_mail TIMESTAMP
);


-- manomboka eto mbola tsy azoko tsara
CREATE TABLE empreintes(
    id SERIAL PRIMARY KEY,
    laboratoire VARCHAR(255),
    date_empreinte TIMESTAMP,
    date_envoi_au_labo TIMESTAMP,
    travail_demande TEXT,
    numero_dent INTEGER,
    observation TEXT,
    date_livraison TIMESTAMP,
    numero_suivi_colis_retour VARCHAR(20),
    numero_facture_labo VARCHAR(20)
);

CREATE TABLE poses(
    id SERIAL PRIMARY KEY,
    date_pose_prevue TIMESTAMP,
    status VARCHAR(255)
);

CREATE TABLE travaux_clotures(
    id SERIAL PRIMARY KEY,
    date_pose_reelle TIMESTAMP,
    organisme_payeur VARCHAR(255),
    montant_encaisse FLOAT,
    date_controle_paiement TIMESTAMP
);

CREATE TABLE cheques(
    id SERIAL PRIMARY KEY,
    numero VARCHAR(20),
    montant_cheque FLOAT,
    nom_document VARCHAR(255),
    date_encaissement TIMESTAMP,
    date_1er_acte TIMESTAMP,
    id_nature_cheque INTEGER REFERENCES cheque_natures(id),
    travaux_sur_devis TEXT,
    id_situation_cheque INTEGER REFERENCES cheque_situations(id),
    observation TEXT
);




