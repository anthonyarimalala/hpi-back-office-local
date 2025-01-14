<?php

namespace App\Models\devis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisEtat extends Model
{
    use HasFactory;
    protected $table = 'devis_etats';
    public $incrementing = false;
    public $timestamps = false;
}
