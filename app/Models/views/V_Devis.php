<?php

namespace App\Models\views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_Devis extends Model
{
    use HasFactory;
    protected $table = 'v_devis';

    public function scopeFiltrer($query, &$filters){
        // 'id_devis_etats' => $request->input('id_devis_etats'),

        if ($filters['id_devis_etats']){
            $query->whereIn('id_devis_etat', $filters['id_devis_etats']);
            $filters['stringFilters'][] = 'Etat de devis';
        }

        // 'date_devis_debut' => $request->input('date_devis_debut'),
        if ($filters['date_devis_debut']){
            $query->where('date', '>=', $filters['date_devis_debut']);
            $filters['stringFilters'][] = 'Date devis debut: '. Carbon::parse($filters['date_devis_debut'])->format('d/m/Y');
        }

        // 'date_devis_fin' => $request->input('date_devis_fin'),
        if ($filters['date_devis_fin']){
            $query->where('date', '<=', $filters['date_devis_fin']);
            $filters['stringFilters'][] = 'Date devis fin: '. Carbon::parse($filters['date_devis_fin'])->format('d/m/Y');
        }

        // 'montant_min' => $request->input('montant_min'),
        if ($filters['montant_min']){
            $query->where('montant', '>=', $filters['montant_min']);
            $filters['stringFilters'][] = 'Montant min: '.$filters['montant_min'];
        }


        // 'montant_max' => $request->input('montant_max'),
        if ($filters['montant_max']) {
            $query->where('montant', '<=', $filters['montant_max']);
            $filters['stringFilters'][] = 'Montant max: '.$filters['montant_max'];
        }

        // 'praticiens' => $request->input('praticiens'),
        if ($filters['praticiens']) {
            $query->whereIn('praticien', $filters['praticiens']);
            $filters['stringFilters'][] = 'Praticiens: '.implode(', ', $filters['praticiens']);
        }

        // 'devis_signe' => $request->input('devis_signe'),
        if ($filters['devis_signe']) {
            $query->where('devis_signe', $filters['devis_signe']);
            $filters['stringFilters'][] = 'Devis signé: '. $filters['devis_signe'];
        }
        // 'date_envoi_pec_debut' => $request->input('date_envoi_pec_debut'),
        if ($filters['date_envoi_pec_debut']) {
            $query->where('date_envoi_pec', '>=', $filters['date_envoi_pec_debut']);
            $filters['stringFilters'][] = 'Date envoi PEC début: '. Carbon::parse($filters['date_envoi_pec_debut'])->format('d/m/Y');
        }

        // 'date_envoi_pec_fin' => $request->input('date_envoi_pec_fin'),
        if ($filters['date_envoi_pec_fin']) {
            $query->where('date_envoi_pec', '<=', $filters['date_envoi_pec_fin']);
            $filters['stringFilters'][] = 'Date envoi PEC fin: '. Carbon::parse($filters['date_envoi_pec_fin'])->format('d/m/Y');
        }

        // 'date_envoi_pec_null' => $request->input('date_envoi_pec_null'),
        if ($filters['date_envoi_pec_null']) {
            $query->where('date_envoi_pec', null);
            $filters['stringFilters'][] = 'Date envoi PEC: sans valeur';
        }

        // 'date_fin_validite_pec_debut' => $request->input('date_fin_validite_pec_debut'),
        if ($filters['date_fin_validite_pec_debut']) {
            $query->where('date_fin_validite_pec', '>=', $filters['date_fin_validite_pec_debut']);
            $filters['stringFilters'][] = 'Date fin validité PEC début: '. Carbon::parse($filters['date_fin_validite_pec_debut'])->format('d/m/Y');
        }

        // 'date_fin_validite_pec_fin' => $request->input('date_fin_validite_pec_fin'),
        if ($filters['date_fin_validite_pec_fin']) {
            $query->where('date_fin_validite_pec', '<=', $filters['date_fin_validite_pec_fin']);
            $filters['stringFilters'][] = 'Date fin validité PEC fin: '. Carbon::parse($filters['date_fin_validite_pec_fin'])->format('d/m/Y');
        }

        // 'date_fin_validite_pec_null' => $request->input('date_fin_validite_pec_null'),
        if ($filters['date_fin_validite_pec_null']) {
            $query->where('date_fin_validite_pec', null);
            $filters['stringFilters'][] = 'Date fin validité PEC: sans valeur';
        }

        // 'part_secu_min' => $request->input('part_secu_min'),
        if ($filters['part_secu_min']) {
            $query->where('part_secu', '>=', $filters['part_secu_min']);
            $filters['stringFilters'][] = 'Part sécu min: '.$filters['part_secu_min'];
        }

        // 'part_secu_max' => $request->input('part_secu_max'),
        if ($filters['part_secu_max']) {
            $query->where('part_secu', '<=', $filters['part_secu_max']);
            $filters['stringFilters'][] = 'Part sécu max: '.$filters['part_secu_max'];
        }
        // 'part_secu_null' => $request->input('part_secu_null'),
        if ($filters['part_secu_null']) {
            $query->where('part_secu', null);
            $filters['stringFilters'][] = 'Part sécu: sans valeur';
        }

        // 'part_mutuelle_min' => $request->input('part_mutuelle_min'),
        if ($filters['part_mutuelle_min']) {
            $query->where('part_mutuelle', '>=', $filters['part_mutuelle_min']);
            $filters['stringFilters'][] = 'Part mutuelle min: '.$filters['part_mutuelle_min'];
        }

        // 'part_mutuelle_max' => $request->input('part_mutuelle_max'),
        if ($filters['part_mutuelle_max']) {
            $query->where('part_mutuelle', '<=', $filters['part_mutuelle_max']);
            $filters['stringFilters'][] = 'Part mutuelle max: '.$filters['part_mutuelle_max'];
        }
        // 'part_mutuelle_null' => $request->input('part_mutuelle_null'),
        if ($filters['part_mutuelle_null']) {
            $query->where('part_mutuelle', null);
            $filters['stringFilters'][] = 'Part mutuelle: sans valeur';
        }


// 'part_rac_min' => $request->input('part_rac_min'),
        if ($filters['part_rac_min']) {
            $query->where('part_rac', '>=', $filters['part_rac_min']);
            $filters['stringFilters'][] = 'Part RAC min: '.$filters['part_rac_min'];
        }

// 'part_rac_max' => $request->input('part_rac_max'),
        if ($filters['part_rac_max']) {
            $query->where('part_rac', '<=', $filters['part_rac_max']);
            $filters['stringFilters'][] = 'Part RAC max: '.$filters['part_rac_max'];
        }
        // 'part_rac_null' => $request->input('part_rac_null'),
        if ($filters['part_rac_null']) {
            $query->where('part_rac', null);
            $filters['stringFilters'][] = 'Part RAC: sans valeur';
        }

        if ($filters['non_regle']) {
            $query->where(function($query) {
                $query->where('part_secu_status', '!=', 'Payé')
                    ->where('part_secu_status', '!=', '');  // Ajout de l'ET pour la condition part_secu_status
                $query->orWhere(function($query) {
                    $query->where('part_mutuelle_status', '!=', 'Payé')
                        ->where('part_mutuelle_status', '!=', '');  // Ajout de l'ET pour la condition part_mutuelle_status
                });
                $query->orWhere(function($query) {
                    $query->where('part_rac_status', '!=', 'Payé')
                        ->where('part_rac_status', '!=', '');  // Ajout de l'ET pour la condition part_rac_status
                });
            });

            $filters['stringFilters'][] = 'Afficher que les non-réglés';
        }


// 'date_1er_appel_debut' => $request->input('date_1er_appel_debut'),
        if ($filters['date_1er_appel_debut']) {
            $query->where('date_1er_appel', '>=', $filters['date_1er_appel_debut']);
            $filters['stringFilters'][] = 'Date 1er appel début: '. Carbon::parse($filters['date_1er_appel_debut'])->format('d/m/Y');
        }

// 'date_1er_appel_fin' => $request->input('date_1er_appel_fin'),
        if ($filters['date_1er_appel_fin']) {
            $query->where('date_1er_appel', '<=', $filters['date_1er_appel_fin']);
            $filters['stringFilters'][] = 'Date 1er appel fin: '. Carbon::parse($filters['date_1er_appel_fin'])->format('d/m/Y');
        }
        // 'date_1er_appel_null' => $request->input('date_1er_appel_null'),
        if ($filters['date_1er_appel_null']) {
            $query->where('date_1er_appel', null);
            $filters['stringFilters'][] = 'Date 1er appel: sans valeur';
        }


// 'date_2eme_appel_debut' => $request->input('date_2eme_appel_debut'),
        if ($filters['date_2eme_appel_debut']) {
            $query->where('date_2eme_appel', '>=', $filters['date_2eme_appel_debut']);
            $filters['stringFilters'][] = 'Date 2ème appel début: '. Carbon::parse($filters['date_2eme_appel_debut'])->format('d/m/Y');
        }

// 'date_2eme_appel_fin' => $request->input('date_2eme_appel_fin'),
        if ($filters['date_2eme_appel_fin']) {
            $query->where('date_2eme_appel', '<=', $filters['date_2eme_appel_fin']);
            $filters['stringFilters'][] = 'Date 2ème appel fin: '. Carbon::parse($filters['date_2eme_appel_fin'])->format('d/m/Y');
        }
        // 'date_2eme_appel_null' => $request->input('date_2eme_appel_null'),
        if ($filters['date_2eme_appel_null']) {
            $query->where('date_2eme_appel', null);
            $filters['stringFilters'][] = 'Date 2ème appel: sans valeur';
        }


// 'date_3eme_appel_debut' => $request->input('date_3eme_appel_debut'),
        if ($filters['date_3eme_appel_debut']) {
            $query->where('date_3eme_appel', '>=', $filters['date_3eme_appel_debut']);
            $filters['stringFilters'][] = 'Date 3ème appel début: '. Carbon::parse($filters['date_3eme_appel_debut'])->format('d/m/Y');
        }

// 'date_3eme_appel_fin' => $request->input('date_3eme_appel_fin'),
        if ($filters['date_3eme_appel_fin']) {
            $query->where('date_3eme_appel', '<=', $filters['date_3eme_appel_fin']);
            $filters['stringFilters'][] = 'Date 3ème appel fin: '. Carbon::parse($filters['date_3eme_appel_fin'])->format('d/m/Y');
        }
        // 'date_3eme_appel_null' => $request->input('date_3eme_appel_null'),
        if ($filters['date_3eme_appel_null']) {
            $query->where('date_3eme_appel', null);
            $filters['stringFilters'][] = 'Date 3ème appel: sans valeur';
        }

// 'date_envoi_mail_debut' => $request->input('date_envoi_mail_debut'),
        if ($filters['date_envoi_mail_debut']) {
            $query->where('date_envoi_mail', '>=', $filters['date_envoi_mail_debut']);
            $filters['stringFilters'][] = 'Date envoi mail début: '. Carbon::parse($filters['date_envoi_mail_debut'])->format('d/m/Y');
        }

// 'date_envoi_mail_fin' => $request->input('date_envoi_mail_fin'),
        if ($filters['date_envoi_mail_fin']) {
            $query->where('date_envoi_mail', '<=', $filters['date_envoi_mail_fin']);
            $filters['stringFilters'][] = 'Date envoi mail fin: '. Carbon::parse($filters['date_envoi_mail_fin'])->format('d/m/Y');
        }
        // 'date_envoi_mail_null' => $request->input('date_envoi_mail_null'),
        if ($filters['date_envoi_mail_null']) {
            $query->where('date_envoi_mail', null);
            $filters['stringFilters'][] = 'Date envoi mail: sans valeur';
        }


        // 'date_empreinte_debut' => $request->input('date_empreinte_debut'),
        if ($filters['date_empreinte_debut']) {
            $query->where('date_empreinte', '>=', $filters['date_empreinte_debut']);
            $filters['stringFilters'][] = 'Date empreinte début: '. Carbon::parse($filters['date_empreinte_debut'])->format('d/m/Y');
        }

        // 'date_empreinte_fin' => $request->input('date_empreinte_fin'),
        if ($filters['date_empreinte_fin']) {
            $query->where('date_empreinte', '<=', $filters['date_empreinte_fin']);
            $filters['stringFilters'][] = 'Date empreinte fin: '. Carbon::parse($filters['date_empreinte_fin'])->format('d/m/Y');
        }
        // 'date_empreinte_null' => $request->input('date_empreinte_null'),
        if ($filters['date_empreinte_null']) {
            $query->where('date_empreinte', null);
            $filters['stringFilters'][] = 'Date empreinte: sans valeur';
        }


// 'date_envoi_labo_debut' => $request->input('date_envoi_labo_debut'),
        if ($filters['date_envoi_labo_debut']) {
            $query->where('date_envoi_labo', '>=', $filters['date_envoi_labo_debut']);
            $filters['stringFilters'][] = 'Date envoi labo début: '. Carbon::parse($filters['date_envoi_labo_debut'])->format('d/m/Y');
        }

// 'date_envoi_labo_fin' => $request->input('date_envoi_labo_fin'),
        if ($filters['date_envoi_labo_fin']) {
            $query->where('date_envoi_labo', '<=', $filters['date_envoi_labo_fin']);
            $filters['stringFilters'][] = 'Date envoi labo fin: '. Carbon::parse($filters['date_envoi_labo_fin'])->format('d/m/Y');
        }
        // 'date_envoi_labo_null' => $request->input('date_envoi_labo_null'),
        if ($filters['date_envoi_labo_null']) {
            $query->where('date_envoi_labo', null);
            $filters['stringFilters'][] = 'Date envoi labo: sans valeur';
        }

        if ($filters['acte_non_regle']) {
            $query->where(function ($q) {
                $q->whereRaw('COALESCE(montant_acte, 0) - COALESCE(montant_encaisse, 0) != 0')
                  ->orWhereNull('montant_acte')
                  ->orWhere('montant_acte', 0);
            });

            $filters['stringFilters'][] = 'Afficher que les actes non-réglés';
        }


// 'date_livraison_debut' => $request->input('date_livraison_debut'),
        if ($filters['date_livraison_debut']) {
            $query->where('date_livraison', '>=', $filters['date_livraison_debut']);
            $filters['stringFilters'][] = 'Date livraison début: '. Carbon::parse($filters['date_livraison_debut'])->format('d/m/Y');
        }

// 'date_livraison_fin' => $request->input('date_livraison_fin'),
        if ($filters['date_livraison_fin']) {
            $query->where('date_livraison', '<=', $filters['date_livraison_fin']);
            $filters['stringFilters'][] = 'Date livraison fin: '. Carbon::parse($filters['date_livraison_fin'])->format('d/m/Y');
        }
        // 'date_livraison_null' => $request->input('date_livraison_null'),
        if ($filters['date_livraison_null']) {
            $query->where('date_livraison', null);
            $filters['stringFilters'][] = 'Date livraison: sans valeur';
        }

// 'numero_suivi' => $request->input('numero_suivi'),
        if ($filters['numero_suivi']) {
            $query->where('numero_suivi', $filters['numero_suivi']);
            $filters['stringFilters'][] = 'Numéro de suivi: '.$filters['numero_suivi'];
        }
        // 'numero_suivi_null' => $request->input('numero_suivi_null'),
        if ($filters['numero_suivi_null']) {
            $query->where('numero_suivi', null);
            $filters['stringFilters'][] = 'Numéro de suivi: sans valeur';
        }


// 'numero_facture_labo' => $request->input('numero_facture_labo'),
        if ($filters['numero_facture_labo']) {
            $query->where('numero_facture_labo', $filters['numero_facture_labo']);
            $filters['stringFilters'][] = 'Numéro facture labo: '.$filters['numero_facture_labo'];
        }
        // 'numero_facture_labo_null' => $request->input('numero_facture_labo_null'),
        if ($filters['numero_facture_labo_null']) {
            $query->where('numero_facture_labo', null);
            $filters['stringFilters'][] = 'Numéro facture labo: sans valeur';
        }



        // 'date_pose_prevue_debut' => $request->input('date_pose_prevue_debut'),
        if ($filters['date_pose_prevue_debut']) {
            $query->where('date_pose_prevue', '>=', $filters['date_pose_prevue_debut']);
            $filters['stringFilters'][] = 'Date pose prévue début: '. Carbon::parse($filters['date_pose_prevue_debut'])->format('d/m/Y');
        }

// 'date_pose_prevue_fin' => $request->input('date_pose_prevue_fin'),
        if ($filters['date_pose_prevue_fin']) {
            $query->where('date_pose_prevue', '<=', $filters['date_pose_prevue_fin']);
            $filters['stringFilters'][] = 'Date pose prévue fin: '. Carbon::parse($filters['date_pose_prevue_fin'])->format('d/m/Y');
        }
        // 'date_pose_prevue_null' => $request->input('date_pose_prevue_null'),
        if ($filters['date_pose_prevue_null']) {
            $query->where('date_pose_prevue', null);
            $filters['stringFilters'][] = 'Date pose prévue: sans valeur';
        }



        // 'id_pose_statuts' => $request->input('id_pose_statuts', []),
        if ($filters['id_pose_statuts']){
            $query->whereIn('id_pose_statut', $filters['id_pose_statuts']);
            $filters['stringFilters'][] = 'Pose status';
        }

        // 'date_pose_reel_debut' => $request->input('date_pose_reel_debut'),
        if ($filters['date_pose_reel_debut']) {
            $query->where('date_pose_reel', '>=', $filters['date_pose_reel_debut']);
            $filters['stringFilters'][] = 'Date pose réelle début: '. Carbon::parse($filters['date_pose_reel_debut'])->format('d/m/Y');
        }

// 'date_pose_reel_fin' => $request->input('date_pose_reel_fin'),
        if ($filters['date_pose_reel_fin']) {
            $query->where('date_pose_reel', '<=', $filters['date_pose_reel_fin']);
            $filters['stringFilters'][] = 'Date pose réelle fin: '. Carbon::parse($filters['date_pose_reel_fin'])->format('d/m/Y');
        }
        // 'date_pose_reel_null' => $request->input('date_pose_reel_null'),
        if ($filters['date_pose_reel_null']) {
            $query->where('date_pose_reel', null);
            $filters['stringFilters'][] = 'Date pose réelle: sans valeur';
        }


// 'montant_encaisse_min' => $request->input('montant_encaisse_min'),
        if ($filters['montant_encaisse_min']) {
            $query->where('montant_encaisse', '>=', $filters['montant_encaisse_min']);
            $filters['stringFilters'][] = 'Montant encaissé min: '.$filters['montant_encaisse_min'];
        }

// 'montant_encaisse_max' => $request->input('montant_encaisse_max'),
        if ($filters['montant_encaisse_max']) {
            $query->where('montant_encaisse', '<=', $filters['montant_encaisse_max']);
            $filters['stringFilters'][] = 'Montant encaissé max: '.$filters['montant_encaisse_max'];
        }
        // 'montant_encaisse_null' => $request->input('montant_encaisse_null'),
        if ($filters['montant_encaisse_null']) {
            $query->where('montant_encaisse', null);
            $filters['stringFilters'][] = 'Montant encaissé: sans valeur';
        }




        // 'date_controle_paiement_debut' => $request->input('date_controle_paiement_debut'),
        if ($filters['date_controle_paiement_debut']) {
            $query->where('date_controle_paiement', '>=', $filters['date_controle_paiement_debut']);
            $filters['stringFilters'][] = 'Date contrôle paiement début: '. Carbon::parse($filters['date_controle_paiement_debut'])->format('d/m/Y');
        }

// 'date_controle_paiement_fin' => $request->input('date_controle_paiement_fin'),
        if ($filters['date_controle_paiement_fin']) {
            $query->where('date_controle_paiement', '<=', $filters['date_controle_paiement_fin']);
            $filters['stringFilters'][] = 'Date contrôle paiement fin: '. Carbon::parse($filters['date_controle_paiement_fin'])->format('d/m/Y');
        }
        // 'date_controle_paiement_null' => $request->input('date_controle_paiement_null'),
        if ($filters['date_controle_paiement_null']) {
            $query->where('date_controle_paiement', null);
            $filters['stringFilters'][] = 'Date contrôle paiement: sans valeur';
        }


// 'numero_cheque' => $request->input('numero_cheque'),
        if ($filters['numero_cheque']) {
            $query->where('numero_cheque', $filters['numero_cheque']);
            $filters['stringFilters'][] = 'Numéro chèque: '.$filters['numero_cheque'];
        }
        // 'numero_cheque_null' => $request->input('numero_cheque_null'),
        if ($filters['numero_cheque_null']) {
            $query->where('numero_cheque', null);
            $filters['stringFilters'][] = 'Numéro chèque: sans valeur';
        }


// 'montant_cheque_min' => $request->input('montant_cheque_min'),
        if ($filters['montant_cheque_min']) {
            $query->where('montant_cheque', '>=', $filters['montant_cheque_min']);
            $filters['stringFilters'][] = 'Montant chèque min: '.$filters['montant_cheque_min'];
        }

// 'montant_cheque_max' => $request->input('montant_cheque_max'),
        if ($filters['montant_cheque_max']) {
            $query->where('montant_cheque', '<=', $filters['montant_cheque_max']);
            $filters['stringFilters'][] = 'Montant chèque max: '.$filters['montant_cheque_max'];
        }
        // 'montant_cheque_null' => $request->input('montant_cheque_null'),
        if ($filters['montant_cheque_null']) {
            $query->where('montant_cheque', null);
            $filters['stringFilters'][] = 'Montant chèque: sans valeur';
        }


// 'date_encaissement_cheque_debut' => $request->input('date_encaissement_cheque_debut'),
        if ($filters['date_encaissement_cheque_debut']) {
            $query->where('date_encaissement_cheque', '>=', $filters['date_encaissement_cheque_debut']);
            $filters['stringFilters'][] = 'Date encaissement chèque début: '. Carbon::parse($filters['date_encaissement_cheque_debut'])->format('d/m/Y');
        }

// 'date_encaissement_cheque_fin' => $request->input('date_encaissement_cheque_fin'),
        if ($filters['date_encaissement_cheque_fin']) {
            $query->where('date_encaissement_cheque', '<=', $filters['date_encaissement_cheque_fin']);
            $filters['stringFilters'][] = 'Date encaissement chèque fin: '. Carbon::parse($filters['date_encaissement_cheque_fin'])->format('d/m/Y');
        }
        // 'date_encaissement_cheque_null' => $request->input('date_encaissement_cheque_null'),
        if ($filters['date_encaissement_cheque_null']) {
            $query->where('date_encaissement_cheque', null);
            $filters['stringFilters'][] = 'Date encaissement chèque: sans valeur';
        }


// 'date_1er_acte_debut' => $request->input('date_1er_acte_debut'),
        if ($filters['date_1er_acte_debut']) {
            $query->where('date_1er_acte', '>=', $filters['date_1er_acte_debut']);
            $filters['stringFilters'][] = 'Date 1er acte début: '. Carbon::parse($filters['date_1er_acte_debut'])->format('d/m/Y');
        }

// 'date_1er_acte_fin' => $request->input('date_1er_acte_fin'),
        if ($filters['date_1er_acte_fin']) {
            $query->where('date_1er_acte', '<=', $filters['date_1er_acte_fin']);
            $filters['stringFilters'][] = 'Date 1er acte fin: '. Carbon::parse($filters['date_1er_acte_fin'])->format('d/m/Y');
        }
        // 'date_1er_acte_null' => $request->input('date_1er_acte_null'),
        if ($filters['date_1er_acte_null']) {
            $query->where('date_1er_acte', null);
            $filters['stringFilters'][] = 'Date 1er acte: sans valeur';
        }



        // 'nature_cheques' => $request->input('nature_cheques'),
        if ($filters['nature_cheques']) {
            $query->whereIn('nature_cheque', $filters['nature_cheques']);
            $filters['stringFilters'][] = 'Nature des chèques: '.implode(', ', $filters['nature_cheques']);
        }

// 'travaux_sur_devis' => $request->input('travaux_sur_devis'),
        if ($filters['travaux_sur_devis']) {
            $query->whereIn('travaux_sur_devis', $filters['travaux_sur_devis']);
            $filters['stringFilters'][] = 'Travaux sur devis: '.implode(', ', $filters['travaux_sur_devis']);
        }

// 'situation_cheques' => $request->input('situation_cheques'),
        if ($filters['situation_cheques']) {
            $query->whereIn('situation_cheque', $filters['situation_cheques']);
            $filters['stringFilters'][] = 'Situation des chèques: '.implode(', ', $filters['situation_cheques']);
        }


    }

    // Getters & Setters

    // debut- INFO-Cheque
    public function getNumero_cheque()
    {
        if ($this->numero_cheque == null) {
            return '...';
        }
        return $this->numero_cheque;
    }

    public function getMontant_cheque()
    {
        if ($this->montant_cheque == null) {
            return '...';
        }
        return number_format($this->montant_cheque, 2, ',', ' ') . ' €'; // Format monétaire
    }

    public function getNom_document()
    {
        if ($this->nom_document == null) {
            return '...';
        }
        return $this->nom_document;
    }

    public function getDate_encaissement_cheque()
    {
        if ($this->date_encaissement_cheque == null) {
            return '...';
        }
        return Carbon::parse($this->date_encaissement_cheque)->format('d/m/Y');
    }

    public function getDate_1er_acte()
    {
        if ($this->date_1er_acte == null) {
            return '...';
        }
        return Carbon::parse($this->date_1er_acte)->format('d/m/Y');
    }

    public function getNature_cheque()
    {
        if ($this->nature_cheque == null) {
            return '...';
        }
        return $this->nature_cheque;
    }

    public function getTravaux_sur_devis()
    {
        if ($this->travaux_sur_devis == null) {
            return '...';
        }
        return $this->travaux_sur_devis;
    }

    public function getSituation_cheque()
    {
        if ($this->situation_cheque == null) {
            return '...';
        }
        return $this->situation_cheque;
    }

    public function getCheque_observation()
    {
        if ($this->cheque_observation == null) {
            return '...';
        }
        return $this->cheque_observation;
    }

    // fin- INFO-Cheque
    public function getDossier()
    {
        if ($this->dossier == null) {
            return '...';
        }
        return $this->dossier;
    }

    public function getId_devis()
    {
        if ($this->id_devis == null) {
            return '...';
        }
        return $this->id_devis;
    }

    public function getLaboratoire()
    {
        if ($this->laboratoire == null) {
            return '...';
        }
        return $this->laboratoire;
    }

    public function getDate_empreinte()
    {
        if ($this->date_empreinte == null) {
            return '...';
        }
        return Carbon::parse($this->date_empreinte)->format('d/m/Y');
    }

    public function getDate_envoi_labo()
    {
        if ($this->date_envoi_labo == null) {
            return '...';
        }
        return Carbon::parse($this->date_envoi_labo)->format('d/m/Y');
    }

    public function getMontantActe()
    {
        if ($this->montant_acte == null){
            return '...';
        }
        return $this->montant_acte;
    }

    public function getTravail_demande()
    {
        if ($this->travail_demande == null) {
            return '...';
        }
        return $this->travail_demande;
    }

    public function getNumero_dent()
    {
        if ($this->numero_dent == null) {
            return '...';
        }
        return $this->numero_dent;
    }

    public function getObservations()
    {
        if ($this->observations == null) {
            return '...';
        }
        return $this->observations;
    }

    public function getCreated_at()
    {
        if ($this->created_at == null) {
            return '...';
        }
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }

    public function getUpdated_at()
    {
        if ($this->updated_at == null) {
            return '...';
        }
        return Carbon::parse($this->updated_at)->format('d/m/Y');
    }

    public function getNumero_suivi()
    {
        if ($this->numero_suivi == null) {
            return '...';
        }
        return $this->numero_suivi;
    }

    public function getPoseStatut()
    {
        if ($this->pose_statut == null) {
            return '...';
        }
        return $this->pose_statut;
    }

    public function getOrganisme_payeur()
    {
        if ($this->organisme_payeur == null) {
            return '...';
        }
        return $this->organisme_payeur;
    }

    public function getMontant_encaisse()
    {
        if ($this->montant_encaisse == null) {
            return '...';
        }
        return number_format($this->montant_encaisse, 2, ',', ' ');
    }

    public function getDate_controle_paiement()
    {
        if ($this->date_controle_paiement == null) {
            return '...';
        }
        return Carbon::parse($this->date_controle_paiement)->format('d/m/Y');
    }

    public function getDate_livraison()
    {
        if ($this->date_livraison == null) {
            return '...';
        }
        return Carbon::parse($this->date_livraison)->format('d/m/Y');
    }

    public function getDate_pose_prevue()
    {
        if ($this->date_pose_prevue == null) {
            return '...';
        }
        return Carbon::parse($this->date_pose_prevue)->format('d/m/Y');
    }

    public function getDate_pose_reel()
    {
        if ($this->date_pose_reel == null) {
            return '...';
        }
        return Carbon::parse($this->date_pose_reel)->format('d/m/Y');
    }
    public function getNumero_facture_labo()
    {
        if ($this->numero_facture_labo == null) {
            return '...';
        }
        return $this->numero_facture_labo;
    }
    public function getMontant(){
        return number_format($this->montant, 2, ',', ' ');
    }
    public function getDate(){
        if ($this->date && $this->date!=null && $this->date!='')
            return Carbon::parse($this->date)->format('d/m/Y');
        else return null;
    }
    public function getDate_envoi_mail(){
        if($this->date_envoi_mail == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_mail)->format('d/m/Y');
    }
    public function getDate_3eme_appel(){
        if ($this->date_3eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_3eme_appel)->format('d/m/Y');
    }
    public function getNote_3eme_appel(){
        if ($this->note_3eme_appel == null){
            return '...';
        }
        return $this->note_3eme_appel;
    }
    public function getDate_2eme_appel(){
        if ($this->date_2eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_2eme_appel)->format('d/m/Y');
    }
    public function getNote_2eme_appel(){
        if ($this->note_2eme_appel == null){
            return '...';
        }
        return $this->note_2eme_appel;
    }
    public function getDate_1er_appel(){
        if ($this->date_1er_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_1er_appel)->format('d/m/Y');
    }
    public function getNote_1er_appel(){
        if ($this->note_1er_appel == null){
            return '...';
        }
        return $this->note_1er_appel;
    }
    public function getDate_depot_chq_rac(){
        if($this->date_depot_chq_rac == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_rac)->format('d/m/Y');
    }
    public function getDate_depot_chq_part_mut(){
        if($this->date_depot_chq_part_mut == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_part_mut)->format('d/m/Y');
    }
    public function getDate_depot_chq_pec(){
        if($this->date_depot_chq_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_pec)->format('d/m/Y');
    }
    public function getDate_paiement_cb_ou_esp(){
        if($this->date_paiement_cb_ou_esp == null){
            return '...';
        }
        return Carbon::parse($this->date_paiement_cb_ou_esp)->format('d/m/Y');
    }
    public function getPart_secu(){
        if ($this->part_secu == null){
            return '...';
        }
        return number_format($this->part_secu, 2, ',', ' ');
    }
    public function getPart_rac(){
        if ($this->part_rac == null){
            return '...';
        }
        return number_format($this->part_rac, 2, ',', ' ');
    }
    public function getPart_mutuelle(){
        if ($this->part_mutuelle == null){
            return '...';
        }
        return number_format($this->part_mutuelle, 2, ',', ' ');
    }
    public function getDate_fin_validite_pec(){
        if ($this->date_fin_validite_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_fin_validite_pec)->format('d/m/Y');
    }
    public function getDate_envoi_pec(){
        if ($this->date_envoi_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_pec)->format('d/m/Y');
    }
    public function getObservation(){
        if ($this->devis_observation == null){
            return "...";
        }
        return $this->devis_observation;
    }
    public function getPraticien()
    {
        if ($this->praticien == null){
            return "...";
        }
        return $this->praticien;
    }
}
