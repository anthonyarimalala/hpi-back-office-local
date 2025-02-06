<?php

namespace App\Models\devis;

use App\Models\dossier\Dossier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';
    protected $fillable = [
        'dossier',
        'date'
    ];

    public static function createDevisSansDossier($dossier, $nom, $status, $mutuelle, $date, $montant, $devis_signe, $praticien, $observation){
        $m_dossier = Dossier::firstOrNew(['dossier'=> $dossier]);
        if ($m_dossier->nom == null || $m_dossier->nom == ''){
            $m_dossier->nom = $nom;
        }
        $m_dossier->status = $status;
        $m_dossier->mutuelle = $mutuelle;
        $m_dossier->is_deleted = 0;
        $m_dossier->save();
        $m_devis = new Devis();
        $m_devis->dossier = $dossier;
        $m_devis->status = $status;
        $m_devis->mutuelle = $mutuelle;
        $m_devis->date = $date;
        $m_devis->montant = $montant;
        $m_devis->devis_signe = $devis_signe;
        $m_devis->praticien = $praticien;
        $m_devis->observation = $observation;
        $m_devis->id_devis_etat = 1;
        $m_devis->save();
        return $m_devis->id;
    }
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
        $devis->id_devis_etat = 1;

        $devis->save();

        // Retourne l'ID du devis créé
        return $devis->id;
    }
    public static function updateDevis($m_h_devis, $id_devis, $devis_signe, $observation, $id_devis_etat){
        $m_devis = Devis::find($id_devis);
        if ($m_devis->devis_signe != $devis_signe) {
            $m_h_devis->action .= "<strong>Devis signé:</strong> " . $m_devis->devis_signe . " => " . $devis_signe . "\n";
            $m_devis->devis_signe = $devis_signe;
        }

        if ($m_devis->observation != $observation) {
            $m_h_devis->action .= "<strong>Observation:</strong> " . $m_devis->observation . " => " . $observation . "\n";
            $m_devis->observation = $observation;
        }

        if ($m_devis->id_devis_etat != $id_devis_etat) {
            $m_h_devis->action .= "<strong>État du devis:</strong> " . $m_devis->id_devis_etat . " => " . $id_devis_etat . "\n";
            $m_devis->id_devis_etat = $id_devis_etat;
        }
        $m_devis->save();
        return $m_devis;
    }

    public function getDate(){
        return Carbon::parse($this->date)->format('d F Y');
    }
}
