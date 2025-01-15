<?php

namespace App\Models\views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_Devis extends Model
{
    use HasFactory;
    protected $table = 'v_devis';


    // Getters & Setters

    public function getMontant(){
        return number_format($this->montant, 2, ',', ' ');
    }
    public function getDate(){
        return Carbon::parse($this->date)->format('d/m/Y');
    }
    public function getDate_envoi_mail(){
        if($this->date_envoi_mail == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_mail)->format('d/m/Y');
    }
    public function getDate_3eme_appel(){
        if ($this->date_3eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_3eme_appel)->format('d/m/Y');
    }
    public function getNote_3eme_appel(){
        if ($this->note_3eme_appel == null){
            return '...';
        }
        return $this->note_3eme_appel;
    }
    public function getDate_2eme_appel(){
        if ($this->date_2eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_2eme_appel)->format('d/m/Y');
    }
    public function getNote_2eme_appel(){
        if ($this->note_2eme_appel == null){
            return '...';
        }
        return $this->note_2eme_appel;
    }
    public function getDate_1er_appel(){
        if ($this->date_1er_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_1er_appel)->format('d/m/Y');
    }
    public function getNote_1er_appel(){
        if ($this->note_1er_appel == null){
            return '...';
        }
        return $this->note_1er_appel;
    }
    public function getDate_depot_chq_rac(){
        if($this->date_depot_chq_rac == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_rac)->format('d/m/Y');
    }
    public function getDate_depot_chq_part_mut(){
        if($this->date_depot_chq_part_mut == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_part_mut)->format('d/m/Y');
    }
    public function getDate_depot_chq_pec(){
        if($this->date_depot_chq_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_pec)->format('d/m/Y');
    }
    public function getDate_paiement_cb_ou_esp(){
        if($this->date_paiement_cb_ou_esp == null){
            return '...';
        }
        return Carbon::parse($this->date_paiement_cb_ou_esp)->format('d/m/Y');
    }
    public function getPart_rac(){
        if ($this->part_rac == null){
            return '...';
        }
        return number_format($this->part_rac, 2, ',', ' ');
    }
    public function getPart_mutuelle(){
        if ($this->part_mutuelle == null){
            return '...';
        }
        return number_format($this->part_mutuelle, 2, ',', ' ');
    }
    public function getDate_fin_validite_pec(){
        if ($this->date_fin_validite_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_fin_validite_pec)->format('d/m/Y');
    }
    public function getDate_envoi_pec(){
        if ($this->date_envoi_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_pec)->format('d/m/Y');
    }
    public function getObservation(){
        if ($this->observation == null){
            return "...";
        }
        return $this->observation;
    }
    public function getPraticien()
    {
        if ($this->praticien == null){
            return "...";
        }
        return $this->praticien;
    }
}
