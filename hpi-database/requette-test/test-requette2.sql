CREATE TABLE l_devis_empreinte(
    id SERIAL PRIMARY KEY,
    id_devis INTEGER REFERENCES devis(id),
    travail_demande VARCHAR(255) NOT NULL,
    numero_dent
)

INSERT INTO prothese_empreintes( id_devis, laboratoire ) VALUES
(13, 'VIVI' );

