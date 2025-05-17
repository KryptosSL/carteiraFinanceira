<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
     protected $table = 'transacoes';
     protected $fillable = [
         "destinatario",
         "remetente_id",
         "valor",
         "tipo",
         "status",
         "uid"
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }

}
