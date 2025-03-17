SELECT
    dos.dossier,
    d.id AS id_devis,
    dos.nom,
    dos.date_naissance,
    d.status,
    d.mutuelle,
    d.date,
    d.montant,
    d.devis_signe,
    d.praticien,
    d.observation AS devis_observation,
    d.is_deleted,
    d.updated_at AS dernier_modif,
    dap.date_envoi_pec,
    dap.date_fin_validite_pec,
    dap.part_mutuelle,
    dap.part_rac,
    dr.date_paiement_cb_ou_esp,
    dr.date_depot_chq_pec,
    dr.date_depot_chq_part_mut,
    dr.date_depot_chq_rac,
    dam.date_1er_appel,
    dam.note_1er_appel,
    dam.date_2eme_appel,
    dam.note_2eme_appel,
    dam.date_3eme_appel,
    dam.note_3eme_appel,
    dam.date_envoi_mail,
    de.id AS id_devis_etat,
    de.etat,
    de.couleur,
    emp.laboratoire,
    emp.date_empreinte,
    emp.date_envoi_labo,
    emp.travail_demande,
    emp.numero_dent,
    emp.observations AS empreinte_observation,
    emp.created_at,
    emp.updated_at,
    rl.date_livraison,
    rl.numero_suivi,
    rl.numero_facture_labo,
    tra.date_pose_prevue,
    pts.id AS id_pose_statut,
    pts.travaux_status AS pose_statut,
    tra.date_pose_reel,
    tra.organisme_payeur,
    tra.montant_encaisse,
    tra.date_controle_paiement,
    ic.numero_cheque,
    ic.montant_cheque,
    ic.nom_document,
    ic.date_encaissement_cheque,
    ic.date_1er_acte   ,
    ic.nature_cheque,
    ic.travaux_sur_devis,
    ic.situation_cheque,
    ic.observation AS cheque_observation
FROM devis d
    WHERE dam.date_1er_appel ,
    dam.date_2eme_appel,
    dam.date_3eme_appel,
    dam.date_envoi_mail,
         JOIN dossiers dos ON d.dossier = dos.dossier
         LEFT JOIN devis_accord_pecs dap ON d.id = dap.id_devis
         LEFT JOIN devis_appels_et_mails dam ON d.id = dam.id_devis
         LEFT JOIN devis_reglements dr ON d.id = dr.id_devis
         LEFT JOIN devis_etats de ON d.id_devis_etat = de.id
         LEFT JOIN prothese_empreintes emp ON d.id = emp.id_devis
         LEFT JOIN prothese_retour_labos rl ON d.id = rl.id_devis
         LEFT JOIN prothese_travaux tra ON d.id = tra.id_devis
         LEFT JOIN info_cheques ic ON d.id = ic.id_devis
         LEFT JOIN prothese_travaux_status pts ON tra.id_pose_statut = pts.id;


<td>{{ $dev->dossier }}</td>
                                                        <td>{{ $dev->nom }}</td>
                                                        <td>{{ $dev->date_1er_appel }}</td>
                                                        <td>{{ $dev->date_1er_appel }}</td>
                                                        <td>{{ $dev->date_2eme_appel }}</td>
                                                        <td>{{ $dev->note_2eme_appel }}</td>
                                                        <td>{{ $dev->date_3eme_appel }}</td>
                                                        <td>{{ $dev->note_3eme_appel }}</td>
                                                        <td>{{ $dev->date_envoi_mail }}</td>

<div class="email-form" id="emailForm">

</div>
Comment faire pour que lorsque je clique sur <a href="#">Envoyer un email</a>, ce modal apparait?
<h2>Envoyer un Email</h2>
<input type="email" id="email" placeholder="Email du destinataire" required>
<input type="text" id="subject" placeholder="Objet" required>
<textarea id="message" placeholder="Votre message" rows="4" required></textarea>
<button>Envoyer</button>
