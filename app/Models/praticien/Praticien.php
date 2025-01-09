<?php

namespace App\Models\praticien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Praticien extends Model
{
    use HasFactory;
    protected $table = 'praticiens';
    public $incrementing = false;
}
