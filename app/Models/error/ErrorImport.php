<?php

namespace App\Models\error;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorImport extends Model
{
    use HasFactory;
    protected $table = 'errors_imports';
}
