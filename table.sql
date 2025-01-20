
ALTER TABLE users
    ADD COLUMN is_deleted INTEGER NOT NULL DEFAULT 0;


-- section: DEVIS
-- DEBUT: clés primaires
CREATE TABLE dossier_statuss(
    status VARCHAR(50) PRIMARY KEY,
    signification VARCHAR(255),
    ordre INTEGER,
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE praticiens(
    praticien VARCHAR(10) PRIMARY KEY,
    nom VARCHAR(255),
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- FIN: clés primaires

CREATE TABLE patients(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    date_naissance DATE,
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


CREATE TABLE dossiers(
    dossier VARCHAR(20) PRIMARY KEY,
    id_patient INTEGER REFERENCES patients(id),
    status VARCHAR(10) REFERENCES dossier_statuss(status),
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE l_dossier_mutuelles(
    id SERIAL PRIMARY KEY,
    dossier VARCHAR(20) REFERENCES dossiers(dossier),
    mutuelle VARCHAR(20),
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE devis_etats(
                            etat VARCHAR(255) PRIMARY KEY,
                            couleur VARCHAR(30)
);
INSERT INTO devis_etats VALUES
                            ('',''),
                            ('Ó relancer', '#FFFF00'),
                            ('Dossier validÚ/ Travaux en cours', '#999999'),
                            ('refusÚ par la mutuelle ', '#FF9900'),
                            ('refusÚ par le patient ou remplacÚ par le praticien', '#FF0000'),
                            ('dossier validÚ', '#00FFFF'),
                            ('dossier C2S', '#4A86E8'),
                            ('a voir avec Faten anomalie', '#9900FF'),
                            ('dossier cloturÚ', '#34A853'),
                            ('devis Ó refaire', '#EA9999'),
                            ('Devis implant', '#FF00FF');

CREATE TABLE devis(
    id SERIAL PRIMARY KEY,
    dossier VARCHAR(20) REFERENCES dossiers(dossier),
    date TIMESTAMP,
    montant FLOAT,
    devis_signe VARCHAR(3),
    praticien VARCHAR(10) REFERENCES praticiens(praticien),
    observation TEXT,
    is_deleted INTEGER DEFAULT 0,
    devis_etat VARCHAR REFERENCES devis_etats(etat),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
CREATE TABLE devis_accord_pecs(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_envoi_pec TIMESTAMP,
    date_fin_validite_pec TIMESTAMP,
    part_mutuelle FLOAT,
    part_rac FLOAT,
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE devis_reglements(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_paiement_cb_ou_esp TIMESTAMP,
    date_depot_chq_pec TIMESTAMP,
    date_depot_chq_part_mut TIMESTAMP,
    date_depot_chq_rac TIMESTAMP,
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
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
    date_envoi_mail TIMESTAMP,
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


INSERT INTO dossier_statuss(status, ordre) VALUES
    ('C2S', 10),
    ('ALD', 0),
    ('CM24', 0),
    ('REGIME DE BASE', 0),
    ('AME', 0),
    ('BDD', 0);

INSERT INTO praticiens(praticien) VALUES
                                      ('RL'),
                                      ('KC');
DROP TABLE info_cheques;
CREATE TABLE info_cheques(
                             id SERIAL PRIMARY KEY,
                             id_devis INTEGER REFERENCES devis(id),
                             numero_cheque VARCHAR(20),
                             montant_cheque FLOAT,
                             nom_document VARCHAR(255),
                             date_encaissement_cheque TIMESTAMP,
                             date_1er_acte TIMESTAMP,
                             nature_cheque VARCHAR(20),
                             travaux_sur_devis TEXT,
                             situation_cheque VARCHAR(255),
                             observation TEXT,
                             created_at TIMESTAMP,
                             updated_at TIMESTAMP
);

CREATE TABLE prothese_empreintes(
                                    id SERIAL PRIMARY KEY,
                                    id_devis SERIAL REFERENCES devis(id),
                                    laboratoire VARCHAR(255),
                                    date_empreinte TIMESTAMP,
                                    date_envoi_labo TIMESTAMP,
                                    travail_demande TEXT,
                                    numero_dent VARCHAR(255),
                                    observations TEXT,
                                    created_at TIMESTAMP,
                                    updated_at TIMESTAMP
);
CREATE TABLE prothese_retour_labos(
                                      id SERIAL PRIMARY KEY,
                                      id_devis INTEGER REFERENCES devis(id),
                                      date_livraison TIMESTAMP,
                                      numero_suivi VARCHAR(20),
                                      numero_facture_labo VARCHAR(20),
                                      created_at TIMESTAMP,
                                      updated_at TIMESTAMP
);
CREATE TABLE prothese_travaux(
                                 id SERIAL PRIMARY KEY,
                                 id_devis INTEGER REFERENCES devis(id),
                                 date_pose_prevue TIMESTAMP,
                                 statut VARCHAR(255),
                                 date_pose_reel TIMESTAMP,
                                 organisme_payeur VARCHAR(255),
                                 montant_encaisse FLOAT,
                                 date_controle_paiement TIMESTAMP,
                                 created_at TIMESTAMP,
                                 updated_at TIMESTAMP
);


