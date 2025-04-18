// Use DBML to define your database structure
// Docs: https://dbml.dbdiagram.io/docs

Table users {
  id integer [pk]
  nom varchar
  prenom varchar
  role varchar
  is_deleted integer [default: 0]
  code_u varchar
  created_at timestamp
  updated_at timestamp
}

Table dossier_statuss {
  status varchar [pk]
  signification varchar
  ordre integer
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table praticiens {
  praticien varchar [pk]
  nom varchar
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table dossiers {
  dossier varchar [pk]
  nom varchar
  date_naissance date
  status varchar
  mutuelle varchar
  email varchar
  is_deleted integer [default: 0]
  code_u varchar
  created_at timestamp
  updated_at timestamp
}

Table devis_etats {
  id serial [pk]
  etat varchar
  couleur varchar
}

Table devis {
  id serial [pk]
  dossier varchar
  status varchar
  mutuelle varchar
  date date
  montant decimal(10,2)
  devis_signe varchar
  praticien varchar
  observation text
  is_deleted integer [default: 0]
  id_devis_etat integer
  created_at timestamp
  updated_at timestamp
}

Table devis_accord_pecs_status {
  status varchar [pk]
  couleur varchar
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table devis_accord_pecs {
  id serial [pk]
  id_devis integer
  date_envoi_pec date
  date_fin_validite_pec date
  part_secu decimal(10,2)
  part_secu_status varchar
  part_mutuelle decimal(10,2)
  part_mutuelle_status varchar
  part_rac decimal(10,2)
  part_rac_status varchar
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table devis_reglements {
  id serial [pk]
  id_devis integer
  reglement_cb decimal(10,2)
  reglement_espece decimal(10,2)
  date_paiement_cb_ou_esp date
  date_depot_chq_pec date
  date_depot_chq_part_mut date
  date_depot_chq_rac date
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table devis_appels_et_mails {
  id serial [pk]
  id_devis integer
  date_1er_appel date
  note_1er_appel text
  date_2eme_appel date
  note_2eme_appel text
  date_3eme_appel date
  note_3eme_appel text
  date_envoi_mail date
  email_sent integer [default: 0]
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table info_cheques_nature_cheques {
  nature_cheque varchar [pk]
  is_deleted integer [default: 0]
}

Table info_cheques_travaux_sur_devis {
  travaux_sur_devis varchar [pk]
  is_deleted integer [default: 0]
}

Table info_cheques_situation_cheques {
  situation_cheque varchar [pk]
  is_deleted integer [default: 0]
}

Table info_cheques {
  id serial [pk]
  id_devis integer
  numero_cheque varchar
  montant_cheque decimal(10,2)
  nom_document varchar
  date_encaissement_cheque date
  date_1er_acte date
  nature_cheque varchar
  travaux_sur_devis varchar
  situation_cheque varchar
  observation text
  created_at timestamp
  updated_at timestamp
}

Table prothese_empreintes {
  id serial [pk]
  id_devis integer
  laboratoire varchar
  date_empreinte date
  date_envoi_labo date
  travail_demande text
  montant_acte decimal(10,2)
  numero_dent varchar
  observations text
  created_at timestamp
  updated_at timestamp
}

Table prothese_retour_labos {
  id serial [pk]
  id_acte integer
  date_livraison date
  numero_suivi varchar
  numero_facture_labo varchar
  created_at timestamp
  updated_at timestamp
}

Table prothese_travaux_status {
  id serial [pk]
  travaux_status varchar
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table prothese_travaux {
  id serial [pk]
  id_acte integer
  date_pose_prevue date
  id_pose_statut integer
  date_pose_reel date
  organisme_payeur varchar
  montant_encaisse decimal(10,2)
  date_controle_paiement date
  created_at timestamp
  updated_at timestamp
}

Table ca_generales {
  id serial [pk]
  id_devis integer
  dossier varchar
  nom_patient varchar
  statut varchar
  mutuelle varchar
  created_at timestamp
  updated_at timestamp
}

Table l_ca_actes_reglements {
  id serial [pk]
  id_ca integer
  id_acte integer [unique]
  date_derniere_modif date
  praticien varchar
  nom_acte varchar
  cotation decimal(10,2)
  controle_securisation varchar
  ro_part_secu decimal(10,2)
  ro_virement_recu decimal(10,2)
  ro_indus_paye decimal(10,2)
  ro_indus_en_attente decimal(10,2)
  ro_indus_irrecouvrable decimal(10,2)
  part_mutuelle decimal(10,2)
  rcs_virement decimal(10,2)
  rcs_especes decimal(10,2)
  rcs_cb decimal(10,2)
  rcsd_cheque decimal(10,2)
  rcsd_especes decimal(10,2)
  rcsd_cb decimal(10,2)
  rac_part_patient decimal(10,2)
  rac_cheque decimal(10,2)
  rac_especes decimal(10,2)
  rac_cb decimal(10,2)
  commentaire text
  is_deleted integer [default: 0]
  created_at timestamp
  updated_at timestamp
}

Table h_protheses {
  id serial [pk]
  code_u varchar
  nom varchar
  id_devis integer
  dossier varchar
  action text
  categorie varchar
  created_at timestamp
  updated_at timestamp
}

Table h_devis {
  id serial [pk]
  code_u varchar
  nom varchar
  id_devis integer
  dossier varchar
  action text
  categorie varchar
  created_at timestamp
  updated_at timestamp
}

Table h_cheques {
  id serial [pk]
  code_u varchar
  nom varchar
  id_devis integer
  dossier varchar
  action text
  categorie varchar
  created_at timestamp
  updated_at timestamp
}

Table h_ca_actes_reglements {
  id serial [pk]
  code_u varchar
  nom varchar
  id_ca_actes_reglement integer
  dossier varchar
  action text
  categorie varchar
  created_at timestamp
  updated_at timestamp
}

Table h_autres {
  id serial [pk]
  code_u varchar
  categorie varchar
  id_element_string varchar
  id_element_integer integer
  link varchar
  action text
  created_at timestamp
  updated_at timestamp
}

Table import_devis {
  dossier text
  id_devis text
  nom text
  date_naissance text
  status text
  mutuelle text
  date text
  montant text
  devis_signe text
  praticien text
  devis_observation text
  is_deleted text
  dernier_modif text
  date_envoi_pec text
  date_fin_validite_pec text
  part_secu text
  part_secu_status text
  part_mutuelle text
  part_mutuelle_status text
  part_rac text
  part_rac_status text
  reglement_cb text
  reglement_espece text
  date_paiement_cb_ou_esp text
  date_depot_chq_pec text
  date_depot_chq_part_mut text
  date_depot_chq_rac text
  date_1er_appel text
  note_1er_appel text
  date_2eme_appel text
  note_2eme_appel text
  date_3eme_appel text
  note_3eme_appel text
  date_envoi_mail text
  id_devis_etat text
  etat text
  couleur text
  laboratoire text
  date_empreinte text
  date_envoi_labo text
  travail_demande text
  montant_acte text
  numero_dent text
  empreinte_observation text
  created_at text
  updated_at text
  date_livraison text
  numero_suivi text
  numero_facture_labo text
  date_pose_prevue text
  pose_statut text
  date_pose_reel text
  organisme_payeur text
  montant_encaisse text
  date_controle_paiement text
  numero_cheque text
  montant_cheque text
  nom_document text
  date_encaissement_cheque text
  date_1er_acte text
  nature_cheque text
  travaux_sur_devis text
  situation_cheque text
  cheque_observation text
}

Table import_ca_actes_reglements {
  id serial [pk]
  date_derniere_modif text
  dossier text
  nom_patient text
  statut text
  mutuelle text
  praticien text
  nom_acte text
  cotation text
  controle_securisation text
  ro_part_secu text
  ro_virement_recu text
  ro_indus_paye text
  ro_indus_en_attente text
  ro_indus_irrecouvrable text
  part_mutuelle text
  rcs_virement text
  rcs_especes text
  rcs_cb text
  rcsd_cheque text
  rcsd_especes text
  rcsd_cb text
  rac_part_patient text
  rac_cheque text
  rac_especes text
  rac_cb text
  commentaire text
  date text
  created_at timestamp
  updated_at timestamp
}

Table errors_imports {
  id serial [pk]
  type integer
  date date
  dossier varchar
  error_message text
  categorie varchar
  description text
  created_at timestamp
  updated_at timestamp
}

// Relations
Ref: dossiers.status > dossier_statuss.status
Ref: dossiers.code_u > users.code_u

Ref: devis.dossier > dossiers.dossier
Ref: devis.status > dossier_statuss.status
Ref: devis.praticien > praticiens.praticien
Ref: devis.id_devis_etat > devis_etats.id

Ref: devis_accord_pecs.id_devis > devis.id
Ref: devis_accord_pecs.part_secu_status > devis_accord_pecs_status.status
Ref: devis_accord_pecs.part_mutuelle_status > devis_accord_pecs_status.status
Ref: devis_accord_pecs.part_rac_status > devis_accord_pecs_status.status

Ref: devis_reglements.id_devis > devis.id
Ref: devis_appels_et_mails.id_devis > devis.id

Ref: info_cheques.id_devis > devis.id
Ref: info_cheques.nature_cheque > info_cheques_nature_cheques.nature_cheque
Ref: info_cheques.travaux_sur_devis > info_cheques_travaux_sur_devis.travaux_sur_devis
Ref: info_cheques.situation_cheque > info_cheques_situation_cheques.situation_cheque

Ref: prothese_empreintes.id_devis > devis.id
Ref: prothese_retour_labos.id_acte > prothese_empreintes.id
Ref: prothese_travaux.id_acte > prothese_empreintes.id
Ref: prothese_travaux.id_pose_statut > prothese_travaux_status.id

Ref: ca_generales.id_devis > devis.id
Ref: ca_generales.dossier > dossiers.dossier

Ref: l_ca_actes_reglements.id_ca > ca_generales.id
Ref: l_ca_actes_reglements.praticien > praticiens.praticien

Ref: h_protheses.code_u > users.code_u
Ref: h_devis.code_u > users.code_u
Ref: h_cheques.code_u > users.code_u
Ref: h_ca_actes_reglements.code_u > users.code_u

Ref: import_ca_actes_reglements.created_at > errors_imports.created_at
