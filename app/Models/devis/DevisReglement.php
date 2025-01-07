<?php

namespace App\Models\devis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisReglement extends Model
{
    use HasFactory;
    protected $table = 'devis_reglements';

    public function createDevisReglement($id_devis, $date_paiement_cb_ou_esp, $date_depot_chq_pec, $date_depot_chq_part_mut, $date_depot_chq_rac){
        $m_DevisReglement = new DevisReglement();
        $m_DevisReglement->id_devis = $id_devis;
        $m_DevisReglement->date_paiement_cb_ou_esp = $date_paiement_cb_ou_esp;
        $m_DevisReglement->date_depot_chq_pec = $date_depot_chq_pec;
        $m_DevisReglement->date_depot_chq_part_mut = $date_depot_chq_part_mut;
        $m_DevisReglement->date_depot_chq_rac = $date_depot_chq_rac;
        $m_DevisReglement->save();
        return $m_DevisReglement->id;
    }
}
