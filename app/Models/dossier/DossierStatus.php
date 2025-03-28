<?php

namespace App\Models\dossier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierStatus extends Model
{
    use HasFactory;
    protected $table = 'dossier_statuss';
    protected $primaryKey = 'status';
    public $incrementing = false;
}
