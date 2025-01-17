<?php

namespace App\Models\devis\prothese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseTravaux extends Model
{
    use HasFactory;
    protected $table = 'prothese_travaux';
    protected $fillable = [
        'id_devis'
    ];
    public static function createOrUpdateTravaux($id_devis, $date_pose_prevue, $statut, $date_pose_reel, $organisme_payeur, $montant_encaisse, $date_controle_paiement)
    {
        // Recherche ou création de l'empreinte
        $travaux = self::firstOrNew(['id_devis' => $id_devis]);
        $travaux->date_pose_prevue = $date_pose_prevue;
        $travaux->statut = $statut;
        $travaux->date_pose_reel = $date_pose_reel;
        $travaux->organisme_payeur = $organisme_payeur;
        $travaux->montant_encaisse = $montant_encaisse;
        $travaux->date_controle_paiement = $date_controle_paiement;

        // Enregistrement de l'empreinte (création ou mise à jour)
        $travaux->save();

        return $travaux;
    }
}
