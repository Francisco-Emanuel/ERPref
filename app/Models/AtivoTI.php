<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// 1. IMPORTAÇÃO NECESSÁRIA PARA O SOFT DELETES
use Illuminate\Database\Eloquent\SoftDeletes;

class AtivoTI extends Model
{
    // 2. USO DO SOFT DELETES E DO HASFACTORY
    use HasFactory, SoftDeletes;

    /**
     * O nome da tabela associada com o model.
     */
    protected $table = 'ativos_ti';

    /**
     * Os atributos que podem ser atribuídos em massa.
     * A coluna 'descricao_problema' foi removida daqui.
     */
    protected $fillable = [
        'nome_ativo',
        'numero_serie',
        'tipo_ativo',
        'status_condicao',
        'user_id', // Renomeado de 'responsavel_id' para seguir a convenção do Laravel
        'departamento_id',
    ];

    /**
     * Define o relacionamento: Um AtivoTI pertence a um Usuário (Responsável).
     */
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define o relacionamento: Um AtivoTI pertence a um Departamento.
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * 3. NOVO RELACIONAMENTO: Um Ativo de TI pode ter muitos Problemas.
     * Isso nos permitirá acessar o histórico de problemas de um ativo.
     */
    public function problemas(): HasMany
    {
        return $this->hasMany(Problema::class, 'ativo_ti_id');
    }
}