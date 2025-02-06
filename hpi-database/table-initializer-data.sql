INSERT INTO dossier_statuss(status, ordre) VALUES
    ('C2S', 10),
    ('ALD', 0),
    ('CM24', 0),
    ('REGIME DE BASE', 0),
    ('AME', 0),
    ('BDD', 0);

INSERT INTO devis_etats(etat, couleur) VALUES
    ('','transparent'),
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
    ('RL'),
    ('KC');