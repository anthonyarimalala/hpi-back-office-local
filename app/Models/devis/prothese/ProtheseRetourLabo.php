<?php

namespace App\Models\devis\prothese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseRetourLabo extends Model
{
    use HasFactory;

    protected $table = 'prothese_retour_labos';
    protected $fillable = [
        'id_devis'
    ];

    public static function createOrUpdateEmpreinte($id_devis, $date_livraison, $numero_suivi, $numero_facture_labo)
    {
        // Recherche ou création de l'empreinte
        $retour_labo = self::firstOrNew(['id_devis' => $id_devis]);
        $retour_labo->date_livraison = $date_livraison;
        $retour_labo->numero_suivi = $numero_suivi;
        $retour_labo->numero_facture_labo = $numero_facture_labo;

        // Enregistrement de l'empreinte (création ou mise à jour)
        $retour_labo->save();

        return $retour_labo;
    }
}
