<?php

namespace App\Models\devis\prothese;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseEmpreinte extends Model
{
    use HasFactory;
    protected $table = 'prothese_empreintes';
    protected $fillable = [
        'id_devis'
    ];
    public static function createOrUpdateEmpreinte($m_h_prothese, $id_devis, $laboratoire, $date_empreinte, $date_envoi_labo, $travail_demande, $numero_dent, $observations) {
        // Recherche ou création de l'empreinte
        $empreinte = self::firstOrNew(['id_devis' => $id_devis]);

        // Mise à jour des attributs
        if ($empreinte->laboratoire != $laboratoire) {
            $m_h_prothese->action .= "<strong>Laboratoire:</strong> " . ($empreinte->laboratoire ?: '...') . " => " . ($laboratoire ?: '...') . "\n";
            $empreinte->laboratoire = $laboratoire;
        }

        if (($empreinte->date_empreinte ? Carbon::parse($empreinte->date_empreinte)->format('Y-m-d') : '') != $date_empreinte) {
            $m_h_prothese->action .= "<strong>Date empreinte:</strong> " . ($empreinte->date_empreinte ? Carbon::parse($empreinte->date_empreinte)->format('d-m-Y') : '...') . " => " . ($date_empreinte ? Carbon::parse($date_empreinte)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_empreinte = $date_empreinte;
        }

        if (($empreinte->date_envoi_labo ? Carbon::parse($empreinte->date_envoi_labo)->format('Y-m-d') : '') != $date_envoi_labo) {
            $m_h_prothese->action .= "<strong>Date envoi labo:</strong> " . ($empreinte->date_envoi_labo ? Carbon::parse($empreinte->date_envoi_labo)->format('d-m-Y') : '...') . " => " . ($date_envoi_labo ? Carbon::parse($date_envoi_labo)->format('d-m-Y') : '...') . "\n";
            $empreinte->date_envoi_labo = $date_envoi_labo;
        }

        if ($empreinte->travail_demande != $travail_demande) {
            $m_h_prothese->action .= "<strong>Travail demandé:</strong> " . ($empreinte->travail_demande ?: '...') . " => " . ($travail_demande ?: '...') . "\n";
            $empreinte->travail_demande = $travail_demande;
        }

        if ($empreinte->numero_dent != $numero_dent) {
            $m_h_prothese->action .= "<strong>Numéro de dent:</strong> " . ($empreinte->numero_dent ?: '...') . " => " . ($numero_dent ?: '...') . "\n";
            $empreinte->numero_dent = $numero_dent;
        }

        if ($empreinte->observations != $observations) {
            $m_h_prothese->action .= "<strong>Observations:</strong> " . ($empreinte->observations ?: '...') . " => " . ($observations ?: '...') . "\n";
            $empreinte->observations = $observations;
        }


        // Sauvegarde (création ou mise à jour)
        $empreinte->save();

        return $empreinte;
    }
}
