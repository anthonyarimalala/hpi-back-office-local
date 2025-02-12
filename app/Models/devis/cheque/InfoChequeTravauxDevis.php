<?php

namespace App\Models\devis\cheque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoChequeTravauxDevis extends Model
{
    use HasFactory;
    protected $table = 'info_cheques_travaux_sur_devis';
    public $incrementing = false;
    public $timestamps = false;
}
