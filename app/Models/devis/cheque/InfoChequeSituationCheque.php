<?php

namespace App\Models\devis\cheque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoChequeSituationCheque extends Model
{
    use HasFactory;
    protected $table = 'info_cheques_situation_cheques';
    public $incrementing = false;
    public $timestamps = false;
}
