<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisAccordPec extends Model
{
    use HasFactory;
    protected $table = 'devis_accord_pecs';
    protected $fillable = [
        'id_devis'
    ];

    public static function createOrUpdateDevisAccordPecs($m_h_devis, $id_devis, $date_envoi_pec, $date_fin_validite_pec, $part_secu, $part_mutuelle, $part_rac, &$withChange = false)
    {
        $m_devisAccordPecs = DevisAccordPec::firstOrNew(['id_devis' => $id_devis]);

        if (($m_devisAccordPecs->date_envoi_pec ? Carbon::parse($m_devisAccordPecs->date_envoi_pec)->format('Y-m-d') : '') != $date_envoi_pec) {
            $m_h_devis->action .= "<strong>Date envoi PEC:</strong> " . ($m_devisAccordPecs->date_envoi_pec ? Carbon::parse($m_devisAccordPecs->date_envoi_pec)->format('d-m-Y') : '...') . " => " . ($date_envoi_pec ? Carbon::parse($date_envoi_pec)->format('d-m-Y') : '...') . "\n";
            $m_devisAccordPecs->date_envoi_pec = $date_envoi_pec;
            $withChange = true;
        }
        if (($m_devisAccordPecs->date_fin_validite_pec ? Carbon::parse($m_devisAccordPecs->date_fin_validite_pec)->format('Y-m-d') : '') != $date_fin_validite_pec) {
            $m_h_devis->action .= "<strong>Date fin validité PEC:</strong> " . ($m_devisAccordPecs->date_fin_validite_pec ? Carbon::parse($m_devisAccordPecs->date_fin_validite_pec)->format('d-m-Y') : '...') . " => " . ($date_fin_validite_pec ? Carbon::parse($date_fin_validite_pec)->format('d-m-Y') : '...') . "\n";
            $m_devisAccordPecs->date_fin_validite_pec = $date_fin_validite_pec;
            $withChange = true;
        }
        if ($m_devisAccordPecs->part_secu != $part_secu) {
            $m_h_devis->action .= "<strong>Part sécu:</strong> " . $m_devisAccordPecs->part_secu . " => " . $part_secu . "\n";
            $m_devisAccordPecs->part_secu = $part_secu;
            $withChange = true;
        }
        if ($m_devisAccordPecs->part_mutuelle != $part_mutuelle) {
            $m_h_devis->action .= "<strong>Part mutuelle:</strong> " . $m_devisAccordPecs->part_mutuelle . " => " . $part_mutuelle . "\n";
            $m_devisAccordPecs->part_mutuelle = $part_mutuelle;
            $withChange = true;
        }
        if ($m_devisAccordPecs->part_rac != $part_rac) {
            $m_h_devis->action .= "<strong>Part RAC:</strong> " . $m_devisAccordPecs->part_rac . " => " . $part_rac . "\n";
            $m_devisAccordPecs->part_rac = $part_rac;
            $withChange = true;
        }
        $m_devisAccordPecs->save();

        return $m_devisAccordPecs->id;
    }

}
