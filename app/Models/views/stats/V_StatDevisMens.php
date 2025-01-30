<?php

namespace App\Models\views\stats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_StatDevisMens extends Model
{
    use HasFactory;
    protected $table = 'v_stat_devis_mens';

    public static function getV_StatDevisMensByDate($today)
    {
        $v_stat_devis_mens = V_StatDevisMens::where('annee_mois', $today)
            ->first();
        if (!$v_stat_devis_mens){
            $v_stat_devis_mens = new V_StatDevisMens();
            $v_stat_devis_mens->annee_mois = $today;
            $v_stat_devis_mens->nbr_devis = 0;
            $v_stat_devis_mens->nbr_devis_signe = 0;
            $v_stat_devis_mens->nbr_devis_non_signe = 0;
        }
        return $v_stat_devis_mens;
    }
}
