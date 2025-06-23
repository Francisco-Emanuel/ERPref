<?php

namespace App\Enums;

enum ChamadoStatus: string
{
    case ABERTO = 'Aberto';
    case EM_ANDAMENTO = 'Em Andamento';
    case RESOLVIDO = 'Resolvido';
    case FECHADO = 'Fechado';
    // Você pode adicionar outros status aqui se precisar, como 'Aguardando Usuário'
}