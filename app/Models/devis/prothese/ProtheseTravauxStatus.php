<?php

namespace App\Models\devis\prothese;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtheseTravauxStatus extends Model
{
    use HasFactory;
    protected $table = 'prothese_travaux_status';
    protected $fillable = [
        'travaux_status',
    ];
}
