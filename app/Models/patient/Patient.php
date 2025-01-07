<?php

namespace App\Models\patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';

    public static function insertPatient($nom, $date_naissance){
        $patient = new Patient();
        $patient->nom = $nom;
        $patient->date_naissance = $date_naissance;
        $patient->save();
        return $patient->id;
    }
}
