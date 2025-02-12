<?php

namespace App\Models\devis\cheque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoChequeNatureCheque extends Model
{
    use HasFactory;
    protected $table = 'info_cheques_nature_cheques';
    public $incrementing = false;
    public $timestamps = false;
}
