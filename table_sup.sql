
CREATE TABLE empreintes(
    id SERIAL PRIMARY KEY,
    id_devis SERIAL REFERENCES devis(id_devis),
    laboratoire VARCHAR(255),
    date_empreinte TIMESTAMP,
    date_envoi_labo TIMESTAMP,
    numero_dent VARCHAR(3),
    observations TEXT
);
CREATE TABLE l_empreinte_travails(
    id_empreinte INTEGER REFERENCES empreintes(id),
    travail VARCHAR(255)
);

CREATE TABLE retour_labo(
    id SERIAL PRIMARY KEY,
    id_devis REFERENCES devis(id),
    date_livraison TIMESTAMP,
    numero_suivi VARCHAR(20),
    numero_facture_labo VARCHAR(20)
);

CREATE TABLE travaux(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    date_pose_prevue TIMESTAMP,
    statut VARCHAR(255),
    date_pose_reel TIMESTAMP,
    organisme_payeur VARCHAR(255),
    montant_encaisse FLOAT,
    date_controle_paiement TIMESTAMP
);
