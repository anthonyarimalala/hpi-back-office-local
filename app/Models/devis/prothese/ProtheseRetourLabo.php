<?php

namespace App\Models\devis\prothese;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseRetourLabo extends Model
{
    use HasFactory;

    protected $table = 'prothese_retour_labos';
    protected $fillable = [
        'id_devis'
    ];

    public static function createOrUpdateEmpreinte($m_h_prothese, $id_devis, $date_livraison, $numero_suivi, $numero_facture_labo, &$withChangeProthese)
    {
        // Recherche ou création de l'empreinte
        $retour_labo = self::firstOrNew(['id_devis' => $id_devis]);
        if (($retour_labo->date_livraison ? Carbon::parse($retour_labo->date_livraison)->format('Y-m-d') : '') != $date_livraison) {
            $m_h_prothese->action .= "<strong>Date livraison:</strong> " . ($retour_labo->date_livraison ? Carbon::parse($retour_labo->date_livraison)->format('d-m-Y') : '...') . " => " . ($date_livraison ? Carbon::parse($date_livraison)->format('d-m-Y') : '...') . "\n";
            $retour_labo->date_livraison = $date_livraison;
            $withChangeProthese = true;
        }

        if ($retour_labo->numero_suivi != $numero_suivi) {
            $m_h_prothese->action .= "<strong>Numéro de suivi:</strong> " . ($retour_labo->numero_suivi ?: '...') . " => " . ($numero_suivi ?: '...') . "\n";
            $retour_labo->numero_suivi = $numero_suivi;
            $withChangeProthese = true;
        }

        if ($retour_labo->numero_facture_labo != $numero_facture_labo) {
            $m_h_prothese->action .= "<strong>Numéro de facture labo:</strong> " . ($retour_labo->numero_facture_labo ?: '...') . " => " . ($numero_facture_labo ?: '...') . "\n";
            $retour_labo->numero_facture_labo = $numero_facture_labo;
            $withChangeProthese = true;
        }



        // Enregistrement de l'empreinte (création ou mise à jour)
        $retour_labo->save();

        return $retour_labo;
    }
}
