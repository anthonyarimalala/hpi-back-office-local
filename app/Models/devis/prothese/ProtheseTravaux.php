<?php

namespace App\Models\devis\prothese;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseTravaux extends Model
{
    use HasFactory;
    protected $table = 'prothese_travaux';
    protected $fillable = [
        'id_devis'
    ];
    public static function createOrUpdateTravaux($m_h_prothese, $id_devis, $date_pose_prevue, $statut, $date_pose_reel, $organisme_payeur, $montant_encaisse, $date_controle_paiement)
    {
        // Recherche ou création de l'empreinte
        $travaux = self::firstOrNew(['id_devis' => $id_devis]);
        if ($travaux->date_pose_prevue != $date_pose_prevue) {
            $m_h_prothese->action .= "<strong>Date pose prévue:</strong> " . ($travaux->date_pose_prevue ? Carbon::parse($travaux->date_pose_prevue)->format('d-m-Y') : '...') . " => " . ($date_pose_prevue ? Carbon::parse($date_pose_prevue)->format('d-m-Y') : '...') . "\n";
            $travaux->date_pose_prevue = $date_pose_prevue;
        }

        if ($travaux->statut != $statut) {
            $m_h_prothese->action .= "<strong>Statut:</strong> " . ($statut ?: '...') . " => " . ($statut ?: '...') . "\n";
            $travaux->statut = $statut;
        }

        if (($travaux->date_pose_reel ? Carbon::parse($travaux->date_pose_reel)->format('Y-m-d') : '') != $date_pose_reel) {
            $m_h_prothese->action .= "<strong>Date pose réelle:</strong> " . ($travaux->date_pose_reel ? Carbon::parse($travaux->date_pose_reel)->format('d-m-Y') : '...') . " => " . ($date_pose_reel ? Carbon::parse($date_pose_reel)->format('d-m-Y') : '...') . "\n";
            $travaux->date_pose_reel = $date_pose_reel;
        }

        if ($travaux->organisme_payeur != $organisme_payeur) {
            $m_h_prothese->action .= "<strong>Organisme payeur:</strong> " . ($travaux->organisme_payeur ?: '...') . " => " . ($organisme_payeur ?: '...') . "\n";
            $travaux->organisme_payeur = $organisme_payeur;
        }

        if ($travaux->montant_encaisse != $montant_encaisse) {
            $m_h_prothese->action .= "<strong>Montant encaissé:</strong> " . ($travaux->montant_encaisse ?: '...') . " => " . ($montant_encaisse ?: '...') . "\n";
            $travaux->montant_encaisse = $montant_encaisse;
        }

        if (($travaux->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('Y-m-d') : '') != $date_controle_paiement) {
            $m_h_prothese->action .= "<strong>Date contrôle paiement:</strong> " . ($travaux->date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . " => " . ($date_controle_paiement ? Carbon::parse($date_controle_paiement)->format('d-m-Y') : '...') . "\n";
            $travaux->date_controle_paiement = $date_controle_paiement;
        }

        // Enregistrement de l'empreinte (création ou mise à jour)
        $travaux->save();

        return $travaux;
    }
}
