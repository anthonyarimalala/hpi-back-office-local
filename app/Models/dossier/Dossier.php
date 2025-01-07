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


    public static function modifierDossier($num_dossier, $status){
        $dossier = Dossier::where('dossier', $num_dossier)->first();
        $dossier->status = $status;
        $dossier->save();
    }
    public static function insertDossier($num_dossier, $id_patient, $status){
        $dossier = new Dossier();
        $dossier->dossier = $num_dossier;
        $dossier->id_patient = $id_patient;
        $dossier->status = $status;
        $dossier->save();
        return $dossier->numero;
    }
}
