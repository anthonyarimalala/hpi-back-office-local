
    ALTER TABLE users
        ADD COLUMN is_deleted INTEGER NOT NULL DEFAULT 0;


    -- section: DEVIS
    CREATE TABLE dossier_statuss(
        status VARCHAR(50) PRIMARY KEY,
        signification VARCHAR(255),
        ordre INTEGER,
        is_deleted INTEGER DEFAULT 0,
        code_u VARCHAR(10) REFERENCES users(code_u),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE praticiens(
        praticien VARCHAR(10) PRIMARY KEY,
        nom VARCHAR(255),
        is_deleted INTEGER DEFAULT 0,
        code_u VARCHAR(10) REFERENCES users(code_u),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE dossiers(
        dossier VARCHAR(20) PRIMARY KEY,
        nom VARCHAR(255),
        date_naissance DATE,
        status VARCHAR(155) REFERENCES dossier_statuss(status),
        mutuelle VARCHAR(255),
        is_deleted INTEGER DEFAULT 0,
        code_u VARCHAR(10) REFERENCES users(code_u),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_etats(
        id SERIAL PRIMARY KEY,
        etat VARCHAR(255),
        couleur VARCHAR(30)
    );

    CREATE TABLE devis(
        id SERIAL PRIMARY KEY,
        dossier VARCHAR(20) REFERENCES dossiers(dossier),
        status VARCHAR(155) REFERENCES dossier_statuss(status),
        mutuelle VARCHAR(10),
        date DATE,
        montant DECIMAL(10, 2),
        devis_signe VARCHAR(3),
        praticien VARCHAR(10) REFERENCES praticiens(praticien),
        observation TEXT,
        is_deleted INTEGER DEFAULT 0,
        id_devis_etat INTEGER REFERENCES devis_etats(id),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_accord_pecs(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        date_envoi_pec DATE,
        date_fin_validite_pec DATE,
        part_mutuelle DECIMAL(10, 2),
        part_rac DECIMAL(10, 2),
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_reglements(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        date_paiement_cb_ou_esp DATE,
        date_depot_chq_pec DATE,
        date_depot_chq_part_mut DATE,
        date_depot_chq_rac DATE,
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_appels_et_mails(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        date_1er_appel DATE,
        note_1er_appel TEXT,
        date_2eme_appel DATE,
        note_2eme_appel TEXT,
        date_3eme_appel DATE,
        note_3eme_appel TEXT,
        date_envoi_mail DATE,
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    -- DROP TABLE info_cheques;
    CREATE TABLE info_cheques(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        numero_cheque VARCHAR(20),
        montant_cheque DECIMAL(10, 2),
        nom_document VARCHAR(255),
        date_encaissement_cheque DATE,
        date_1er_acte DATE,
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
        date_empreinte DATE,
        date_envoi_labo DATE,
        travail_demande TEXT,
        numero_dent VARCHAR(255),
        observations TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE prothese_retour_labos(
                                        id SERIAL PRIMARY KEY,
                                        id_devis INTEGER REFERENCES devis(id),
                                        date_livraison DATE,
                                        numero_suivi VARCHAR(20),
                                        numero_facture_labo VARCHAR(20),
                                        created_at TIMESTAMP,
                                        updated_at TIMESTAMP
    );

    CREATE TABLE prothese_travaux(
                                    id SERIAL PRIMARY KEY,
                                    id_devis INTEGER REFERENCES devis(id),
                                    date_pose_prevue DATE,
                                    statut VARCHAR(255),
                                    date_pose_reel DATE,
                                    organisme_payeur VARCHAR(255),
                                    montant_encaisse DECIMAL(10, 2),
                                    date_controle_paiement DATE,
                                    created_at TIMESTAMP,
                                    updated_at TIMESTAMP
    );

    CREATE TABLE ca_actes_reglements(
        id SERIAL PRIMARY KEY,
        date_derniere_modif DATE,
        dossier VARCHAR(20) REFERENCES dossiers(dossier),
        statut VARCHAR(50),
        mutuelle  VARCHAR(255),
        praticien VARCHAR(10) REFERENCES praticiens(praticien),
        nom_acte VARCHAR(255),
        cotation DECIMAL(10, 2),
        controle_securisation VARCHAR(255),
        ro_part_secu DECIMAL(10, 2),
        ro_virement_recu DECIMAL(10, 2),
        ro_indus_paye DECIMAL(10, 2),
        ro_indus_en_attente DECIMAL(10, 2),
        ro_indus_irrecouvrable DECIMAL(10, 2),
        part_mutuelle DECIMAL(10, 2),
        rcs_virement DECIMAL(10, 2),
        rcs_especes DECIMAL(10, 2),
        rcs_cb DECIMAL(10, 2),
        rcsd_cheque DECIMAL(10, 2),
        rcsd_especes DECIMAL(10, 2),
        rcsb_cb DECIMAL(10, 2),
        rac_part_patient DECIMAL(10, 2),
        rac_cheque DECIMAL(10, 2),
        rac_especes DECIMAL(10, 2),
        rac_cb DECIMAL(10, 2),
        commentaire TEXT, 
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );


    CREATE TABLE h_protheses(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        id_devis INTEGER,
        action TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_devis(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        id_devis INTEGER,
        action TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_cheques(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        id_devis INTEGER,
        action TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_autres(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        categorie VARCHAR(155),
        id_element_string VARCHAR(20),
        id_element_integer INTEGER,
        link VARCHAR(255),
        action TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

CREATE TABLE import_devis (
    dossier VARCHAR(255),
    id_devis SERIAL PRIMARY KEY,
    nom VARCHAR(255),
    date_naissance DATE,
    status VARCHAR(50),
    mutuelle VARCHAR(255),
    date DATE,
    montant DECIMAL(10, 2),
    devis_signe VARCHAR(3),
    praticien VARCHAR(255),
    devis_observation TEXT,
    is_deleted BOOLEAN DEFAULT FALSE,
    dernier_modif DATE DEFAULT CURRENT_DATE,
    date_envoi_pec DATE,
    date_fin_validite_pec DATE,
    part_mutuelle DECIMAL(10, 2),
    part_rac DECIMAL(10, 2),
    date_paiement_cb_ou_esp DATE,
    date_depot_chq_pec DATE,
    date_depot_chq_part_mut DATE,
    date_depot_chq_rac DATE,
    date_1er_appel DATE,
    note_1er_appel TEXT,
    date_2eme_appel DATE,
    note_2eme_appel TEXT,
    date_3eme_appel DATE,
    note_3eme_appel TEXT,
    date_envoi_mail DATE,
    id_devis_etat INT,
    etat VARCHAR(50),
    couleur VARCHAR(50),
    laboratoire VARCHAR(255),
    date_empreinte DATE,
    date_envoi_labo DATE,
    travail_demande TEXT,
    numero_dent INT,
    empreinte_observation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_livraison DATE,
    numero_suivi VARCHAR(50),
    numero_facture_labo VARCHAR(50),
    date_pose_prevue DATE,
    pose_statut VARCHAR(50),
    date_pose_reel DATE,
    organisme_payeur VARCHAR(255),
    montant_encaisse DECIMAL(10, 2),
    date_controle_paiement DATE,
    numero_cheque VARCHAR(50),
    montant_cheque DECIMAL(10, 2),
    nom_document VARCHAR(255),
    date_encaissement_cheque DATE,
    date_1er_acte DATE,
    nature_cheque VARCHAR(50),
    travaux_sur_devis TEXT,
    situation_cheque VARCHAR(50),
    cheque_observation TEXT
);
