INSERT INTO dossier_statuss(status, ordre) VALUES
    ('', 0),
    ('C2S', 10),
    ('ALD', 0),
    ('CM24', 0),
    ('REGIME DE BASE', 0),
    ('AME', 0),
    ('BDD', 0);

INSERT INTO devis_etats(etat, couleur) VALUES
    ('','#FFFFFF'),
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

INSERT INTO praticiens(praticien) VALUES
    (''),
    ('RL'),
    ('KC');

INSERT INTO info_cheques_nature_cheques(nature_cheque) VALUES
    (''),
    ('PEC'),
    ('RAC'),
    ('PART MUT'),
    ('ANOMALIE');

INSERT INTO info_cheques_travaux_sur_devis(travaux_sur_devis) VALUES
    (''),
    ('EN COURS'),
    ('CLOTUREE');

INSERT INTO info_cheques_situation_cheques(situation_cheque) VALUES
    (''),
    ('A RESTITUER'),
    ('A ENCAISSER'),
    ('EN ATTENTE'),
    ('ANOMALIE'),
    ('PERIME'),
    ('DEJA ENCAISSE');

INSERT INTO prothese_travaux_status(travaux_status) VALUES
    (''),
    ('PosÚe/PayÚe'),
    ('PosÚe/Non-PayÚe'),
    ('Non posÚe/ RDV pose plannifiÚ'),
    ('Non posÚe/Pas de RDV'),
    ('Anomalie'),
    ('Double envoi'),
    ('Double facturation'),
    ('RDV honorÚ /Non facturÚ'),
    ('ProthÞse non revenue'),
    ('Partiellement posÚ/pas de rdv'),
    ('Partiellement posÚ/avec rdv');

INSERT INTO devis_accord_pecs_status(status, couleur) VALUES
    ('', ''),
    ('Non PayÚ', '#FF0000'),
    ('PayÚ', '#008000');


