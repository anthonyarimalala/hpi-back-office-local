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
    }
}
