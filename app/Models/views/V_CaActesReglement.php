<?php

namespace App\Models\views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_CaActesReglement extends Model
{
    use HasFactory;
    protected $table = 'v_ca_actes_reglements';

    public function scopeFilter($query, &$filters){
        if ($filters['date_derniere_modif_debut']) {
            $query->where('date_derniere_modif', '>=', $filters['date_derniere_modif_debut']);
            $filters['stringFilters'][] = 'Date de dèrniere modification debut: '. Carbon::parse($filters['date_derniere_modif_debut'])->format('d/m/Y');
        }
        if ($filters['date_derniere_modif_fin']) {
            $query->where('date_derniere_modif', '<=', $filters['date_derniere_modif_fin']);
            $filters['stringFilters'][] = 'Date de dèrniere modification fin: '. Carbon::parse($filters['date_derniere_modif_fin'])->format('d/m/Y');
        }
        if ($filters['status']){
            $query->whereIn('statut', $filters['status']);
            $filters['stringFilters'][] = 'Status: '.implode(', ', $filters['status']);
        }
        if ($filters['praticiens']){
            $query->whereIn('praticien', $filters['praticiens']);
            $filters['stringFilters'][] = 'Praticiens: '.implode(', ', $filters['praticiens']);
        }
        if ($filters['montant_min_cotation']){
            $query->where('cotation', '>=', $filters['montant_min_cotation']);
            $filters['stringFilters'][] = 'Cotation min: '.$filters['montant_min_cotation'];
        }
        if ($filters['montant_max_cotation']){
            $query->where('cotation', '<=', $filters['montant_max_cotation']);
            $filters['stringFilters'][] = 'Cotation max: '.$filters['montant_max_cotation'];
        }
        if (count($filters['non_regle_cotation'])>0){
            $query->whereRaw('cotation > (ro_part_secu_paye + part_mutuelle_paye + rac_part_patient_paye)');
            $filters['stringFilters'][] = 'Cotation Non réglé ';
        }
        if (count($filters['regle_cotation'])>0){
            $query->whereRaw('cotation = (ro_part_secu_paye + part_mutuelle_paye + rac_part_patient_paye)');
            $filters['stringFilters'][] = 'Cotation réglé ';
        }
        if ($filters['montant_min_secu']){
            $query->where('ro_part_secu', '>=', $filters['montant_min_secu']);
            $filters['stringFilters'][] = 'Part Sécu min: '. $filters['montant_min_secu'];
        }
        if ($filters['montant_max_secu']){
            $query->where('ro_part_secu', '<=', $filters['montant_max_secu']);
            $filters['stringFilters'][] = 'Part Sécu max: '. $filters['montant_max_secu'];
        }
        if (count($filters['non_regle_secu'])>0){
            $query->whereColumn('ro_part_secu', '>', 'ro_part_secu_paye');
            $filters['stringFilters'][] = 'Afficher que les Part Sécu non réglés';
        }
        if ($filters['montant_min_mut']) {
            $query->where('part_mutuelle', '>=', $filters['montant_min_mut']);
            $filters['stringFilters'][] = 'Part Mutuelle min: ' . $filters['montant_min_mut'];
        }
        if ($filters['montant_max_mut']) {
            $query->where('part_mutuelle', '<=', $filters['montant_max_mut']);
            $filters['stringFilters'][] = 'Part Mutuelle max: ' . $filters['montant_max_mut'];
        }
        if (count($filters['non_regle_mut'])>0){
            $query->whereColumn('part_mutuelle', '>', 'part_mutuelle_paye');
            $filters['stringFilters'][] = 'Afficher que les Part Mut non réglés';
        }
        if ($filters['montant_min_patient']) {
            $query->where('rac_part_patient', '>=', $filters['montant_min_patient']);
            $filters['stringFilters'][] = 'Part Patient min: ' . $filters['montant_min_patient'];
        }
        if ($filters['montant_max_patient']) {
            $query->where('rac_part_patient', '<=', $filters['montant_max_patient']);
            $filters['stringFilters'][] = 'Part Patient max: ' . $filters['montant_max_patient'];
        }
        if (count($filters['non_regle_mut'])>0){
            $query->whereColumn('rac_part_patient', '>', 'rac_part_patient_paye');
            $filters['stringFilters'][] = 'Afficher que les Part Patient non réglés';
        }

    }
}
