<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisReglement extends Model
{
    use HasFactory;
    protected $table = 'devis_reglements';
    protected $fillable = [
        'id_devis'
    ];

    public static function createDevisReglement($m_h_devis, $id_devis, $reglement_cb, $reglement_espece, $date_paiement_cb_ou_esp, $date_depot_chq_pec, $date_depot_chq_part_mut, $date_depot_chq_rac, &$withChange = false){
        $m_DevisReglement = DevisReglement::firstOrNew(['id_devis'=>$id_devis]);
        $m_DevisReglement->id_devis = $id_devis;
        if ($m_DevisReglement->reglement_cb != $reglement_cb){
            $m_h_devis->action .= "<strong>CB:</strong> " . $m_DevisReglement->reglement_cb . " => " . $reglement_cb . "\n";
            $m_DevisReglement->reglement_cb = $reglement_cb;
            $withChange = true;
        }
        if ($m_DevisReglement->reglement_espece != $reglement_espece){
            $m_h_devis->action .= "<strong>Espece:</strong> " . $m_DevisReglement->reglement_espece . " => " . $reglement_espece . "\n";
            $m_DevisReglement->reglement_espece = $reglement_espece;
            $withChange = true;
        }
        if (($m_DevisReglement->date_paiement_cb_ou_esp ? Carbon::parse($m_DevisReglement->date_paiement_cb_ou_esp)->format('Y-m-d') : '') != $date_paiement_cb_ou_esp) {
            $m_h_devis->action .= "<strong>Date paiement CB ou ESP:</strong> " . ($m_DevisReglement->date_paiement_cb_ou_esp ? Carbon::parse($m_DevisReglement->date_paiement_cb_ou_esp)->format('d-m-Y') : '...') . " => " . ($date_paiement_cb_ou_esp ? Carbon::parse($date_paiement_cb_ou_esp)->format('d-m-Y') : '...') . "\n";
            $m_DevisReglement->date_paiement_cb_ou_esp = $date_paiement_cb_ou_esp;
            $withChange = true;
        }

        if (($m_DevisReglement->date_depot_chq_pec ? Carbon::parse($m_DevisReglement->date_depot_chq_pec)->format('Y-m-d') : '') != $date_depot_chq_pec) {
            $m_h_devis->action .= "<strong>Date dépôt chèque PEC:</strong> " . ($m_DevisReglement->date_depot_chq_pec ? Carbon::parse($m_DevisReglement->date_depot_chq_pec)->format('d-m-Y') : '...') . " => " . ($date_depot_chq_pec ? Carbon::parse($date_depot_chq_pec)->format('d-m-Y') : '...') . "\n";
            $m_DevisReglement->date_depot_chq_pec = $date_depot_chq_pec;
            $withChange = true;
        }

        if (($m_DevisReglement->date_depot_chq_part_mut ? Carbon::parse($m_DevisReglement->date_depot_chq_part_mut)->format('Y-m-d') : '') != $date_depot_chq_part_mut) {
            $m_h_devis->action .= "<strong>Date dépôt chèque part mutuelle:</strong> " . ($m_DevisReglement->date_depot_chq_part_mut ? Carbon::parse($m_DevisReglement->date_depot_chq_part_mut)->format('d-m-Y') : '...') . " => " . ($date_depot_chq_part_mut ? Carbon::parse($date_depot_chq_part_mut)->format('d-m-Y') : '...') . "\n";
            $m_DevisReglement->date_depot_chq_part_mut = $date_depot_chq_part_mut;
            $withChange = true;
        }

        if (($m_DevisReglement->date_depot_chq_rac ? Carbon::parse($m_DevisReglement->date_depot_chq_rac)->format('Y-m-d') : '') != $date_depot_chq_rac) {
            $m_h_devis->action .= "<strong>Date dépôt chèque RAC:</strong> " . ($m_DevisReglement->date_depot_chq_rac ? Carbon::parse($m_DevisReglement->date_depot_chq_rac)->format('d-m-Y') : '...') . " => " . ($date_depot_chq_rac ? Carbon::parse($date_depot_chq_rac)->format('d-m-Y') : '...') . "\n";
            $m_DevisReglement->date_depot_chq_rac = $date_depot_chq_rac;
            $withChange = true;
        }

        $m_DevisReglement->save();
        return $m_DevisReglement->id;
    }
}
