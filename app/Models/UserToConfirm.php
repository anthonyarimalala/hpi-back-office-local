<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToConfirm extends Model
{
    use HasFactory;
    protected $table = "users_to_confirms";
}
