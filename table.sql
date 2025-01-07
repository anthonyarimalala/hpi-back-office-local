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

CREATE TABLE pose_statuss(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(255),
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE cheque_natures(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(20),
    is_deleted INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE cheque_situations(
    id SERIAL PRIMARY KEY,
    designation VARCHAR(20),
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

CREATE TABLE devis(
    id SERIAL PRIMARY KEY,
    dossier VARCHAR(20) REFERENCES dossiers(dossier),
    date TIMESTAMP,
    montant FLOAT,
    devis_signe VARCHAR(3),
    praticien VARCHAR(10) REFERENCES praticiens(praticien),
    observation TEXT,
    is_deleted INTEGER DEFAULT 0,
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
