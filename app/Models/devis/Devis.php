<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';

    public static function createDevis($dossier, $date, $montant, $devis_signe, $praticien, $observation){
        $m_devis = new Devis();
        $m_devis->dossier = $dossier;
        $m_devis->date = $date;
        $m_devis->montant = $montant;
        $m_devis->devis_signe = $devis_signe;
        $m_devis->praticien = $praticien;
        $m_devis->observation = $observation;
        $m_devis->save();
        return $m_devis->id;
    }

    public function getDate(){
        return Carbon::parse($this->date)->format('d F Y');
    }
}
