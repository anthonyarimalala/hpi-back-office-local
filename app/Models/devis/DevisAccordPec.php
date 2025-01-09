<?php

namespace App\Models\devis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisAccordPec extends Model
{
    use HasFactory;
    protected $table = 'devis_accord_pecs';
    protected $fillable = [
        'id_devis'
    ];
    public static function createOrUpdateDevisAccordPecs($id_devis, $date_envoi_pec, $date_fin_validite_pec, $part_mutuelle, $part_rac)
    {
        $m_devisAccordPecs = DevisAccordPec::firstOrNew(['id_devis' => $id_devis]);

        $m_devisAccordPecs->date_envoi_pec = $date_envoi_pec;
        $m_devisAccordPecs->date_fin_validite_pec = $date_fin_validite_pec;
        $m_devisAccordPecs->part_mutuelle = $part_mutuelle;
        $m_devisAccordPecs->part_rac = $part_rac;

        $m_devisAccordPecs->save();

        return $m_devisAccordPecs->id;
    }

}
