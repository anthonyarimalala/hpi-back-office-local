
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
        email VARCHAR(255),
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
        mutuelle VARCHAR(255),
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

    CREATE TABLE devis_accord_pecs_status(
        status VARCHAR(155) PRIMARY KEY,
        couleur VARCHAR(30),
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_accord_pecs(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        date_envoi_pec DATE,
        date_fin_validite_pec DATE,
        part_secu DECIMAL(10, 2),
        part_secu_status VARCHAR(155) REFERENCES devis_accord_pecs_status(status),
        part_mutuelle DECIMAL(10, 2),
        part_mutuelle_status VARCHAR(155) REFERENCES devis_accord_pecs_status(status),
        part_rac DECIMAL(10, 2),
        part_rac_status VARCHAR(155) REFERENCES devis_accord_pecs_status(status),
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE devis_reglements(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        reglement_cb DECIMAL(10, 2),
        reglement_espece DECIMAL(10, 2),
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
        email_sent INTEGER DEFAULT 0,
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    -- DROP TABLE info_cheques;
    CREATE TABLE info_cheques_nature_cheques(
        nature_cheque VARCHAR(50) PRIMARY KEY,
        is_deleted INTEGER DEFAULT 0
    );
    CREATE TABLE info_cheques_travaux_sur_devis(
        travaux_sur_devis VARCHAR(50) PRIMARY KEY,
        is_deleted INTEGER DEFAULT 0
    );
    CREATE TABLE info_cheques_situation_cheques(
        situation_cheque VARCHAR(50) PRIMARY KEY,
        is_deleted INTEGER DEFAULT 0
    );
    CREATE TABLE info_cheques(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        numero_cheque VARCHAR(20),
        montant_cheque DECIMAL(10, 2),
        nom_document VARCHAR(255),
        date_encaissement_cheque DATE,
        date_1er_acte DATE,
        nature_cheque VARCHAR(50) REFERENCES info_cheques_nature_cheques(nature_cheque),
        travaux_sur_devis VARCHAR(50) REFERENCES info_cheques_travaux_sur_devis(travaux_sur_devis),
        situation_cheque VARCHAR(255) REFERENCES info_cheques_situation_cheques(situation_cheque),
        observation TEXT,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE prothese_travaux_status(
        id SERIAL PRIMARY KEY,
        travaux_status VARCHAR(255),
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE protheses(
        id SERIAL PRIMARY KEY,
        id_devis SERIAL REFERENCES devis(id),
        laboratoire VARCHAR(255),
        date_empreinte DATE,
        date_envoi_labo DATE,
        travail_demande TEXT,
        montant_acte DECIMAL(10, 2),
        numero_dent VARCHAR(255),
        observations TEXT,
        date_livraison DATE,
        numero_suivi VARCHAR(20),
        numero_facture_labo VARCHAR(20),
        date_pose_prevue DATE,
        id_pose_statut INTEGER REFERENCES prothese_travaux_status(id),
        date_pose_reel DATE,
        organisme_payeur VARCHAR(255),
        montant_encaisse DECIMAL(10, 2),
        date_controle_paiement DATE,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE ca_generales(
        id SERIAL PRIMARY KEY,
        id_devis INTEGER REFERENCES devis(id),
        dossier VARCHAR(20) REFERENCES dossiers(dossier),
        nom_patient VARCHAR(255),
        statut VARCHAR(50),
        mutuelle  VARCHAR(255),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );

    CREATE TABLE l_ca_actes_reglements(
        id SERIAL PRIMARY KEY,
        id_ca INTEGER REFERENCES ca_generales(id),
        id_acte INTEGER UNIQUE,
        date_derniere_modif DATE,
        praticien VARCHAR(10) REFERENCES praticiens(praticien),
        nom_acte VARCHAR(255) NOT NULL,
        cotation DECIMAL(10, 2) NOT NULL,
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
        rcsd_cb DECIMAL(10, 2),
        rac_part_patient DECIMAL(10, 2),
        rac_cheque DECIMAL(10, 2),
        rac_especes DECIMAL(10, 2),
        rac_cb DECIMAL(10, 2),
        commentaire TEXT,
        is_deleted INTEGER DEFAULT 0,
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );



    CREATE TABLE h_devis(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        nom VARCHAR(255),
        id_devis INTEGER,
        dossier VARCHAR(20),
        action TEXT,
        categorie VARCHAR(255),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_protheses(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        nom VARCHAR(255),
        id_devis INTEGER,
        dossier VARCHAR(20),
        id_acte INTEGER,
        action TEXT,
        categorie VARCHAR(255),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_cheques(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        nom VARCHAR(255),
        id_devis INTEGER,
        dossier VARCHAR(20),
        action TEXT,
        categorie VARCHAR(255),
        created_at TIMESTAMP,
        updated_at TIMESTAMP
    );
    CREATE TABLE h_ca_actes_reglements(
        id SERIAL PRIMARY KEY,
        code_u VARCHAR(10),
        nom VARCHAR(255),
        id_devis INTEGER,
        id_ca_actes_reglement INTEGER,
        dossier VARCHAR(20),
        action TEXT,
        categorie VARCHAR(255),
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
    dossier TEXT,
    id_devis TEXT,
    nom TEXT,
    date_naissance TEXT,
    status TEXT,
    mutuelle TEXT,
    date TEXT,
    montant TEXT,
    devis_signe TEXT,
    praticien TEXT,
    devis_observation TEXT,
    is_deleted TEXT,
    dernier_modif TEXT,
    date_envoi_pec TEXT,
    date_fin_validite_pec TEXT,
    part_secu TEXT,
    part_secu_status TEXT,
    part_mutuelle TEXT,
    part_mutuelle_status TEXT,
    part_rac TEXT,
    part_rac_status TEXT,
    reglement_cb TEXT,
    reglement_espece TEXT,
    date_paiement_cb_ou_esp TEXT,
    date_depot_chq_pec TEXT,
    date_depot_chq_part_mut TEXT,
    date_depot_chq_rac TEXT,
    date_1er_appel TEXT,
    note_1er_appel TEXT,
    date_2eme_appel TEXT,
    note_2eme_appel TEXT,
    date_3eme_appel TEXT,
    note_3eme_appel TEXT,
    date_envoi_mail TEXT,
    id_devis_etat TEXT,
    etat TEXT,
    couleur TEXT,
    laboratoire TEXT,
    date_empreinte TEXT,
    date_envoi_labo TEXT,
    travail_demande TEXT,
    montant_acte TEXT,
    numero_dent TEXT,
    empreinte_observation TEXT,
    created_at TEXT,
    updated_at TEXT,
    date_livraison TEXT,
    numero_suivi TEXT,
    numero_facture_labo TEXT,
    date_pose_prevue TEXT,
    pose_statut TEXT,
    date_pose_reel TEXT,
    organisme_payeur TEXT,
    montant_encaisse TEXT,
    date_controle_paiement TEXT,
    numero_cheque TEXT,
    montant_cheque TEXT,
    nom_document TEXT,
    date_encaissement_cheque TEXT,
    date_1er_acte TEXT,
    nature_cheque TEXT,
    travaux_sur_devis TEXT,
    situation_cheque TEXT,
    cheque_observation TEXT
);

CREATE TABLE import_ca_actes_reglements(
    id SERIAL PRIMARY KEY,
    date_derniere_modif TEXT,
    dossier TEXT,
    nom_patient TEXT,
    statut TEXT,
    mutuelle  TEXT,
    praticien TEXT,
    nom_acte TEXT,
    cotation TEXT,
    controle_securisation TEXT,
    ro_part_secu TEXT,
    ro_virement_recu TEXT,
    ro_indus_paye TEXT,
    ro_indus_en_attente TEXT,
    ro_indus_irrecouvrable TEXT,
    part_mutuelle TEXT,
    rcs_virement TEXT,
    rcs_especes TEXT,
    rcs_cb TEXT,
    rcsd_cheque TEXT,
    rcsd_especes TEXT,
    rcsd_cb TEXT,
    rac_part_patient TEXT,
    rac_cheque TEXT,
    rac_especes TEXT,
    rac_cb TEXT,
    commentaire TEXT,
    date TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE errors_imports(
    id SERIAL PRIMARY KEY,
    type INTEGER, -- 1 pour devis et 2 pour ca.
    date DATE,
    dossier VARCHAR(20),
    error_message TEXT,
    categorie VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);


