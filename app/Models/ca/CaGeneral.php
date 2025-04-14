<?php

namespace App\Models\ca;

use App\Models\devis\Devis;
use App\Models\views\V_CaActesReglement;
use App\Models\views\V_Devis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CaGeneral extends Model
{
    use HasFactory;
    protected $table = 'ca_generales';

    protected $fillable = [
        'id_devis',
        'dossier',
        'nom_patient',
        'statut',
        'mutuelle',
        'created_at',
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
