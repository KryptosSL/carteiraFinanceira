<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "cliente";
    protected $fillable = [
        'user_id',
        'nome' ,
        'email' 
    ];
}
