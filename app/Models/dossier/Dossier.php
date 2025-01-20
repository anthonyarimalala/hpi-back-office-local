<?php

namespace App\Models\dossier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;
    protected $primaryKey = 'dossier';
    protected $table = 'dossiers';
    public $incrementing = false;


    public static function modifierDossier($num_dossier, $status, $mutuelle){
        $dossier = Dossier::where('dossier', $num_dossier)->first();
        $dossier->status = $status;
        $dossier->mutuelle = $mutuelle;
        $dossier->save();
    }
    public static function insertDossier($num_dossier, $nom, $date_naissance, $status, $mutuelle){
        $dossier = new Dossier();
        $dossier->dossier = $num_dossier;
        $dossier->nom = $nom;
        $dossier->date_naissance = $date_naissance;
        $dossier->status = $status;
        $dossier->mutuelle = $mutuelle;
        $dossier->save();
        return $dossier->numero;
    }
}
