<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacoes extends Model
{
    protected $fillable = [
        "cliente_id" ,
        "valor" ,
        "operacao",
        "transferencia_id"  
    ];
}
