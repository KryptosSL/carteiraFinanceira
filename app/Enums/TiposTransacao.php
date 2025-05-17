<?php

namespace App\Enums;

enum TiposTransacao: string
{
    case DEPOSITO = 'deposito';
    case TRANSFERENCIA_ENTRADA = 'transferencia_entrada';
    case TRANSFERENCIA_SAIDA = 'transferencia_saida';
    case ESTORNO = 'estorno';
    case ENTRADA = 'entrada';
    case SAIDA = 'saida';
    
}

