<?php

namespace App\Models\devis\prothese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseEmpreinte extends Model
{
    use HasFactory;
    protected $table = 'prothese_empreintes';
    protected $fillable = [
        'id_devis'
    ];
    public static function createOrUpdateEmpreinte($id_devis, $laboratoire, $date_empreinte, $date_envoi_labo, $travail_demande, $numero_dent, $observations) {
        // Recherche ou création de l'empreinte
        $empreinte = self::firstOrNew(['id_devis' => $id_devis]);

        // Mise à jour des attributs
        $empreinte->laboratoire = $laboratoire;
        $empreinte->date_empreinte = $date_empreinte;
        $empreinte->date_envoi_labo = $date_envoi_labo;
        $empreinte->travail_demande = $travail_demande;
        $empreinte->numero_dent = $numero_dent;
        $empreinte->observations = $observations;

        // Sauvegarde (création ou mise à jour)
        $empreinte->save();

        return $empreinte;
    }
}
