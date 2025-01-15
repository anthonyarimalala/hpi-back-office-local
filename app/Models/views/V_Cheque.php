<?php

namespace App\Models\views;

use App\Models\devis\cheque\InfoCheque;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_Cheque extends Model
{
    use HasFactory;
    protected $table = 'v_cheques';



// Getters avec gestion des valeurs null et formatage des dates
    public function getNumero_cheque()
    {
        return $this->numero_cheque ?? '...';
    }

    public function getMontant_cheque()
    {
        return number_format($this->montant_cheque, 2, ',', ' ') ?? '...';
    }

    public function getNom_document()
    {
        return $this->nom_document ?? '...';
    }

    public function getDate_encaissement_cheque()
    {
        return $this->date_encaissement_cheque ? Carbon::parse($this->date_encaissement_cheque)->format('d/m/Y') : '...';
    }

    public function getDate_1er_acte()
    {
        return $this->date_1er_acte ? Carbon::parse($this->date_1er_acte)->format('d/m/Y') : '...';
    }

    public function getNature_cheque()
    {
        return $this->nature_cheque ?? '...';
    }

    public function getTravaux_sur_devis()
    {
        return $this->travaux_sur_devis ?? '...';
    }

    public function getSituation_cheque()
    {
        return $this->situation_cheque ?? '...';
    }

    public function getObservation()
    {
        return $this->observation ?? '...';
    }

}
