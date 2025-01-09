<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';

    public static function updateDevis($id_devis, $devis_signe, $observation){
        $m_devis = Devis::find($id_devis);
        $m_devis->devis_signe = $devis_signe;
        $m_devis->observation = $observation;
        $m_devis->save();
        return $m_devis->id;
    }

    public function getDate(){
        return Carbon::parse($this->date)->format('d F Y');
    }
}
