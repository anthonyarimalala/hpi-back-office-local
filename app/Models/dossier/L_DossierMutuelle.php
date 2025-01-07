<?php

namespace App\Models\dossier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class L_DossierMutuelle extends Model
{
    use HasFactory;
    protected $table = 'l_dossier_mutuelles';

    public static function deleteL_DossierMutuelle($dossier, $mutuelle){
        $m_dossierMutuelle = L_DossierMutuelle::where('dossier', $dossier)
            ->where('mutuelle', $mutuelle)
            ->first();
        $m_dossierMutuelle->is_deleted = 1;
        $m_dossierMutuelle->save();
    }
    public static function insertL_DossierMutuelle($dossier, $mutuelle){
        $m_dossierMutuelle = new L_DossierMutuelle();
        $m_dossierMutuelle->dossier = $dossier;
        $m_dossierMutuelle->mutuelle = $mutuelle;
        $m_dossierMutuelle->save();
        return $m_dossierMutuelle->id;
    }
}
