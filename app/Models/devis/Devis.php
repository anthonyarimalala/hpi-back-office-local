<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';

    public static function createDevis($dossier, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation)
    {
        // Création d'un nouveau devis
        $devis = new Devis();
        $devis->dossier = $dossier;
        $devis->status = $status;
        $devis->mutuelle = $mutuelle;
        $devis->date = $date;
        $devis->montant = $montant;
        $devis->devis_signe = $devis_signe;
        $devis->praticien = $praticien;
        $devis->observation = $observation;

        $devis->save();

        // Retourne l'ID du devis créé
        return $devis->id;
    }
    public static function updateDevis($id_devis, $devis_signe, $observation, $devis_etat){
        $m_devis = Devis::find($id_devis);
        $m_devis->devis_signe = $devis_signe;
        $m_devis->observation = $observation;
        $m_devis->devis_etat = $devis_etat;
        $m_devis->save();
        return $m_devis;
    }

    public function getDate(){
        return Carbon::parse($this->date)->format('d F Y');
    }
}
