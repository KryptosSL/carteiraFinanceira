<?php
namespace App\Enums;

enum StatusTransacao: string
{
    case PENDENTE     = 'pendente';
    case CONCLUIDA    = 'concluida';
    case CANCELADA    = 'cancelada';
    case FALHOU       = 'falhou';
    case ESTORNO = 'estorno';
}
?>