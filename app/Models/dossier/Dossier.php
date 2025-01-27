<?php

namespace App\Models\dossier;

use App\Models\hist\H_Autre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        $m_h_autres = new H_Autre();
        $dossier = new Dossier();
        $dossier->dossier = $num_dossier;
        $dossier->nom = $nom;
        $dossier->date_naissance = $date_naissance;
        $dossier->status = $status;
        $dossier->mutuelle = $mutuelle;
        $dossier->save();
        $m_h_autres->code_u = Auth::user()->code_u;
        $m_h_autres->categorie = "Dossier";
        $m_h_autres->id_element_string = $dossier->dossier;
        $m_h_autres->action = "<strong>Nouveau dossier: </strong>".$dossier->dossier.", ".$nom;
        $m_h_autres->link = $dossier->dossier."/liste-devis";
        $m_h_autres->save();
        return $dossier->numero;
    }
}
