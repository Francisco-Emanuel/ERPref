<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chamado extends Model
{
    use HasFactory;

    /**
     * O nome da tabela. Laravel provavelmente adivinharia 'chamados' corretamente,
     * mas é uma boa prática especificar.
     */
    protected $table = 'chamados';

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'titulo',
        'problema_id',
        'status',
        'prioridade',
        'solucao_final',
        'data_resolucao',
        'data_fechamento',
        'avaliacao',
        'solicitante_id',
        'tecnico_id',
        'categoria_id',
        'ativo_id', // Mantivemos para acesso rápido
    ];

    /**
     * Define o relacionamento: Um Chamado PERTENCE A um Problema.
     */
    public function problema(): BelongsTo
    {
        return $this->belongsTo(Problema::class);
    }

    /**
     * Define o relacionamento: Um Chamado TEM UM solicitante (que é um Usuário).
     */
    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    /**
     * Define o relacionamento: Um Chamado TEM UM técnico responsável (que é um Usuário).
     */
    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    /**
     * Define o relacionamento: Um Chamado PERTENCE A uma Categoria.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Define o relacionamento: Um Chamado TEM MUITAS atualizações (o histórico).
     */
    public function atualizacoes(): HasMany
    {
        return $this->hasMany(AtualizacaoChamado::class, 'chamado_id')->latest(); // Ordena da mais nova para a mais antiga
    }
}