<?php

namespace App\Models\ca;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CaGeneral extends Model
{
    use HasFactory;
    protected $table = 'ca_generales';

    protected $fillable = [
        'dossier',
        'nom_patient',
        'statut',
        'mutuelle',
    ];

    public static function createCa(Request $request){
        $dossier = $request->input('dossiers');
        $nom_patient = $request->input('nom_patient');
        $statut = $request->input('statut');
        $mutuelle = $request->input('mutuelle');


        $m_ca = new CaGeneral();
        $m_ca->dossier = $dossier;
        $m_ca->nom_patient = $nom_patient;
        $m_ca->statut = $statut;
        $m_ca->mutuelle = $mutuelle;
        $m_ca->save();
        return $m_ca;
    }

}
