<?php

namespace App\Models\ca;

use App\Models\devis\Devis;
use App\Models\dossier\Dossier;
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


    public static function createCaActeReglement(Request $request, $ca_generale) {
        $id_ca = $ca_generale->id_ca;
        $m_ca_acte_reglement = new L_CaActesReglement();
        
    }

    public static function createCaGenerale(Request $request){
        $dossier = $request->input('dossiers');
        $nom_patient = $request->input('nom_patient');
        $statut = $request->input('statut');
        $mutuelle = $request->input('mutuelle');
        $m_dossier = Dossier::where('dossier', $dossier)->first();
        $nom_patient = $m_dossier->nom;
        if(!$dossier){
            throw new \Exception("Ce patient n'est pas enrigistré");
        }

        $m_ca = new CaGeneral();
        $m_ca->dossier = $dossier;
        $m_ca->nom_patient = $nom_patient;
        $m_ca->statut = $statut;
        $m_ca->mutuelle = $mutuelle;
        $m_ca->save();
        return $m_ca;
    }

}
