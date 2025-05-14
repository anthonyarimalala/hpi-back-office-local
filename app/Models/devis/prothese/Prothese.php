<?php

namespace App\Models\devis\prothese;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prothese extends Model
{
    use HasFactory;
    protected $table = "protheses";
    protected $fillable = [
        'id_devis',
        'laboratoire',
        'date_empreinte',
        'date_envoi_labo',
        'travail_demande',
        'montant_acte',
        'numero_dent',
        'observations',
        'date_livraison',
        'numero_suivi',
        'numero_facture_labo',
        'date_pose_prevue',
        'id_pose_statut',
        'date_pose_reel',
        'organisme_payeur',
        'montant_encaisse',
        'date_controle_paiement',
    ];

    // Créer d'autres empreintes s'il y'en a déjà un.
    public static function createEmpreinte($m_h_prothese, $id_devis, $laboratoire, $date_empreinte, $date_envoi_labo, $travail_demande, $montant_acte, $numero_dent, $observations, $date_livraison, $numero_suivi, $numero_facture_labo, $date_pose_prevue, $id_pose_statut, $date_pose_reel, $organisme_payeur, $montant_encaisse, $date_controle_paiement,  &$withChangeProthese = false){
        $empreinte = Prothese::firstOrNew(['id_devis' => $id_devis, 'travail_demande' => $travail_demande]);
        // Mise à jour des attributs
        $empreinte->laboratoire = $laboratoire;
        $empreinte->date_empreinte = $date_empreinte;
        $empreinte->date_envoi_labo = $date_envoi_labo;


            $m_h_prothese->action .= "<strong>Travail demandé(nouveau):</strong> " . ($empreinte->travail_demande ?: '...') . " => " . ($travail_demande ?: '...') . "\n";
            $empreinte->travail_demande = $travail_demande;
            $withChangeProthese = true;

        if ($empreinte->montant_acte != $montant_acte) {
            $m_h_prothese->action .= "<strong>Montant acte:</strong> " . ($empreinte->montant_acte ?: '...') . " => " . ($montant_acte ?: '...') . "\n";
            $empreinte->montant_acte = $montant_acte;
            $withChangeProthese = true;
        }
        if ($empreinte->numero_dent != $numero_dent) {
            $m_h_prothese->action .= "<strong>Numéro de dent:</strong> " . ($empreinte->numero_dent ?: '...') . " => " . ($numero_dent ?: '...') . "\n";
            $empreinte->numero_dent = $numero_dent;
            $withChangeProthese = true;
        }
        if ($empreinte->observations != $observations) {
            $m_h_prothese->action .= "<strong>Observations:</strong> " . ($empreinte->observations ?: '...') . " => " . ($observations ?: '...') . "\n";
            $empreinte->observations = $observations;
            $withChangeProthese = true;
        }
        if (($empreinte->date_livraison ? Carbon::parse($empreinte->date_livraison)->format('Y-m-d') : '') != $date_livraison) {
            $m_h_prothese->action .= "<strong>Date livraison:</strong> " . ($empreinte->date_livraison ? Carbon::parse($empreinte->date_livraison)->format('d-m-Y') : '...') . " => " . ($date_livraison ? Carbon::parse($date_livraison)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_livraison = $date_livraison;
            $withChangeProthese = true;
        }

        if ($empreinte->numero_suivi != $numero_suivi) {
            $m_h_prothese->action .= "<strong>Numéro de suivi:</strong> " . ($empreinte->numero_suivi ?: '...') . " => " . ($numero_suivi ?: '...') . "\n";
            $empreinte->numero_suivi = $numero_suivi;
            $withChangeProthese = true;
        }

        if ($empreinte->numero_facture_labo != $numero_facture_labo) {
            $m_h_prothese->action .= "<strong>Numéro de facture labo:</strong> " . ($empreinte->numero_facture_labo ?: '...') . " => " . ($numero_facture_labo ?: '...') . "\n";
            $empreinte->numero_facture_labo = $numero_facture_labo;
            $withChangeProthese = true;
        }

        $m_ancien_pose_status = ProtheseTravauxStatus::find($empreinte->id_pose_statut);
        $m_nouveau_pose_status = ProtheseTravauxStatus::find($id_pose_statut);


        if ($empreinte->date_pose_prevue != $date_pose_prevue) {
            $m_h_prothese->action .= "<strong>Date pose prévue:</strong> " . ($empreinte->date_pose_prevue ? Carbon::parse($empreinte->date_pose_prevue)->format('d-m-Y') : '...') . " => " . ($date_pose_prevue ? Carbon::parse($date_pose_prevue)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_pose_prevue = $date_pose_prevue;
            $withChangeProthese = true;
        }

        if ($empreinte->id_pose_statut != $id_pose_statut) {
            if ($m_ancien_pose_status) {
                $ancien_statut = $m_ancien_pose_status->travaux_status ?: '...';
            } else {
                $ancien_statut = '...';
            }
            if ($m_nouveau_pose_status) {
                $nouveau_statut = $m_nouveau_pose_status->travaux_status ?: '...';
            } else {
                $nouveau_statut = '...';
            }
            $m_h_prothese->action .= "<strong>Statut:</strong> " . $ancien_statut . " => " . $nouveau_statut . "\n";
            $empreinte->id_pose_statut = $m_nouveau_pose_status ? $m_nouveau_pose_status->id : null;
            $withChangeProthese = true;
        }


        if (($empreinte->date_pose_reel ? Carbon::parse($empreinte->date_pose_reel)->format('Y-m-d') : '') != $date_pose_reel) {
            $m_h_prothese->action .= "<strong>Date pose réelle:</strong> " . ($empreinte->date_pose_reel ? Carbon::parse($empreinte->date_pose_reel)->format('d-m-Y') : '...') . " => " . ($date_pose_reel ? Carbon::parse($date_pose_reel)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_pose_reel = $date_pose_reel;
            $withChangeProthese = true;
        }

        if ($empreinte->organisme_payeur != $organisme_payeur) {
            $m_h_prothese->action .= "<strong>Organisme payeur:</strong> " . ($empreinte->organisme_payeur ?: '...') . " => " . ($organisme_payeur ?: '...') . "\n";
            $empreinte->organisme_payeur = $organisme_payeur;
            $withChangeProthese = true;
        }

        if ($empreinte->montant_encaisse != $montant_encaisse) {
            $m_h_prothese->action .= "<strong>Montant encaissé:</strong> " . ($empreinte->montant_encaisse ?: '...') . " => " . ($montant_encaisse ?: '...') . "\n";
            $empreinte->montant_encaisse = $montant_encaisse;
            $withChangeProthese = true;
        }

        if (($empreinte->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('Y-m-d') : '') != $date_controle_paiement) {
            $m_h_prothese->action .= "<strong>Date contrôle paiement:</strong> " . ($empreinte->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . " => " . ($date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_controle_paiement = $date_controle_paiement;
            $withChangeProthese = true;
        }
        $empreinte->save();
        //L_CaActesReglement::createCaAfterDevis($id_devis, $empreinte->id, $travail_demande, $montant_acte, $date_empreinte);
        return $empreinte;
    }
    // création de prothese lors d'une création de devis (tous les valeurs du prothese sont null)
    public static function createOrUpdateProthese(
        $m_h_prothese,
        $id_devis,
        $id_acte,
        $laboratoire,
        $date_empreinte,
        $date_envoi_labo,
        $travail_demande,
        $montant_acte,
        $numero_dent,
        $observations,
        $date_devis,
        $date_livraison,
        $numero_suivi,
        $numero_facture_labo,
        $date_pose_prevue,
        $id_pose_statut,
        $date_pose_reel,
        $organisme_payeur,
        $montant_encaisse,
        $date_controle_paiement,
        &$withChangeProthese
    ) {
        // Recherche ou création de l'empreinte
        $prothese = Prothese::find($id_acte);
        if(!$prothese) {
            $prothese = new Prothese();
            $prothese->id_devis = $id_devis;
        }
        $m_h_prothese->action .= "<strong>Travail demandé:</strong> " . ($travail_demande ?: '...') ."\n";

        // Mise à jour des attributs
        if ($prothese->laboratoire != $laboratoire) {
            $m_h_prothese->action .= "<strong>Laboratoire:</strong> " . ($prothese->laboratoire ?: '...') . " => " . ($laboratoire ?: '...') . "\n";
            $prothese->laboratoire = $laboratoire;
            $withChangeProthese = true;
        }

        if (($prothese->date_empreinte ? Carbon::parse($prothese->date_empreinte)->format('Y-m-d') : '') != $date_empreinte) {
            $m_h_prothese->action .= "<strong>Date empreinte:</strong> " . ($prothese->date_empreinte ? Carbon::parse($prothese->date_empreinte)->format('d-m-Y') : '...') . " => " . ($date_empreinte ? Carbon::parse($date_empreinte)->format('d-m-Y') : '...') . "\n";
            $prothese->date_empreinte = $date_empreinte;
            $withChangeProthese = true;
        }

        if (($prothese->date_envoi_labo ? Carbon::parse($prothese->date_envoi_labo)->format('Y-m-d') : '') != $date_envoi_labo) {
            $m_h_prothese->action .= "<strong>Date envoi labo:</strong> " . ($prothese->date_envoi_labo ? Carbon::parse($prothese->date_envoi_labo)->format('d-m-Y') : '...') . " => " . ($date_envoi_labo ? Carbon::parse($date_envoi_labo)->format('d-m-Y') : '...') . "\n";
            $prothese->date_envoi_labo = $date_envoi_labo;
            $withChangeProthese = true;
        }

        if ($prothese->travail_demande != $travail_demande) {
            $m_h_prothese->action .= "<strong>Travail demandé:</strong> " . ($prothese->travail_demande ?: '...') . " => " . ($travail_demande ?: '...') . "\n";
            $prothese->travail_demande = $travail_demande;
            $withChangeProthese = true;
        }

        if ($prothese->montant_acte != $montant_acte) {
            $m_h_prothese->action .= "<strong>Montant acte:</strong> " . ($prothese->montant_acte ?: '...') . " => " . ($montant_acte ?: '...') . "\n";
            $prothese->montant_acte = $montant_acte;
            $withChangeProthese = true;
        }

        if ($prothese->numero_dent != $numero_dent) {
            $m_h_prothese->action .= "<strong>Numéro de dent:</strong> " . ($prothese->numero_dent ?: '...') . " => " . ($numero_dent ?: '...') . "\n";
            $prothese->numero_dent = $numero_dent;
            $withChangeProthese = true;
        }

        if ($prothese->observations != $observations) {
            $m_h_prothese->action .= "<strong>Observations:</strong> " . ($prothese->observations ?: '...') . " => " . ($observations ?: '...') . "\n";
            $prothese->observations = $observations;
            $withChangeProthese = true;
        }

        if (($prothese->date_livraison ? Carbon::parse($prothese->date_livraison)->format('Y-m-d') : '') != $date_livraison) {
            $m_h_prothese->action .= "<strong>Date livraison:</strong> " . ($prothese->date_livraison ? Carbon::parse($prothese->date_livraison)->format('d-m-Y') : '...') . " => " . ($date_livraison ? Carbon::parse($date_livraison)->format('d-m-Y') : '...') . "\n";
            $prothese->date_livraison = $date_livraison;
            $withChangeProthese = true;
        }

        if ($prothese->numero_suivi != $numero_suivi) {
            $m_h_prothese->action .= "<strong>Numéro de suivi:</strong> " . ($prothese->numero_suivi ?: '...') . " => " . ($numero_suivi ?: '...') . "\n";
            $prothese->numero_suivi = $numero_suivi;
            $withChangeProthese = true;
        }

        if ($prothese->numero_facture_labo != $numero_facture_labo) {
            $m_h_prothese->action .= "<strong>Numéro de facture labo:</strong> " . ($prothese->numero_facture_labo ?: '...') . " => " . ($numero_facture_labo ?: '...') . "\n";
            $prothese->numero_facture_labo = $numero_facture_labo;
            $withChangeProthese = true;
        }

        if ($prothese->date_pose_prevue != $date_pose_prevue) {
            $m_h_prothese->action .= "<strong>Date pose prévue:</strong> " . ($prothese->date_pose_prevue ? Carbon::parse($prothese->date_pose_prevue)->format('d-m-Y') : '...') . " => " . ($date_pose_prevue ? Carbon::parse($date_pose_prevue)->format('d-m-Y') : '...') . "\n";
            $prothese->date_pose_prevue = $date_pose_prevue;
            $withChangeProthese = true;
        }

        // retrouver les clés primaires anciens pour faire une historique
        $m_ancien_pose_status = ProtheseTravauxStatus::find($prothese->id_pose_statut);
        $m_nouveau_pose_status = ProtheseTravauxStatus::find($id_pose_statut);
        if ($prothese->id_pose_statut != $id_pose_statut) {
            if ($m_ancien_pose_status) {
                $ancien_statut = $m_ancien_pose_status->travaux_status ?: '...';
            } else {
                $ancien_statut = '...';
            }
            if ($m_nouveau_pose_status) {
                $nouveau_statut = $m_nouveau_pose_status->travaux_status ?: '...';
            } else {
                $nouveau_statut = '...';
            }
            $m_h_prothese->action .= "<strong>Statut:</strong> " . $ancien_statut . " => " . $nouveau_statut . "\n";
            $prothese->id_pose_statut = $m_nouveau_pose_status ? $m_nouveau_pose_status->id : null;
            $withChangeProthese = true;
        }


        if (($prothese->date_pose_reel ? Carbon::parse($prothese->date_pose_reel)->format('Y-m-d') : '') != $date_pose_reel) {
            $m_h_prothese->action .= "<strong>Date pose réelle:</strong> " . ($prothese->date_pose_reel ? Carbon::parse($prothese->date_pose_reel)->format('d-m-Y') : '...') . " => " . ($date_pose_reel ? Carbon::parse($date_pose_reel)->format('d-m-Y') : '...') . "\n";
            $prothese->date_pose_reel = $date_pose_reel;
            $withChangeProthese = true;
        }

        if ($prothese->organisme_payeur != $organisme_payeur) {
            $m_h_prothese->action .= "<strong>Organisme payeur:</strong> " . ($prothese->organisme_payeur ?: '...') . " => " . ($organisme_payeur ?: '...') . "\n";
            $prothese->organisme_payeur = $organisme_payeur;
            $withChangeProthese = true;
        }

        if ($prothese->montant_encaisse != $montant_encaisse) {
            $m_h_prothese->action .= "<strong>Montant encaissé:</strong> " . ($prothese->montant_encaisse ?: '...') . " => " . ($montant_encaisse ?: '...') . "\n";
            $prothese->montant_encaisse = $montant_encaisse;
            $withChangeProthese = true;
        }

        if (($prothese->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('Y-m-d') : '') != $date_controle_paiement) {
            $m_h_prothese->action .= "<strong>Date contrôle paiement:</strong> " . ($prothese->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . " => " . ($date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . "\n";
            $prothese->date_controle_paiement = $date_controle_paiement;
            $withChangeProthese = true;
        }

        //echo 'empreinte: '. $empreinte. '<br>';
        // Sauvegarde (création ou mise à jour)
        if($date_devis == null){
            $date_devis = Carbon::parse(time: $prothese->created_at)->format('Y-m-d') ;
        }
        //L_CaActesReglement::createCaAfterDevis($id_devis, $id_acte, $travail_demande, $montant_acte, $date_devis);

        $prothese->save();
        return $prothese;
    }
}
