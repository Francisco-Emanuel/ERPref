<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AtivoTI extends Model
{
    use HasFactory;
    protected $table = "ativos_ti";

    protected $fillable = [
        'identificacao',
        'descricao_problema',
        'tipo_ativo',
        'setor',
        'usuario_responsavel',
        'status'
    ];
}
