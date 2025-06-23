<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtualizacaoChamado extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada com o model.
     * É importante especificar para evitar erros de pluralização do Laravel.
     */
    protected $table = 'atualizacoes_chamado';

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'texto',
        'chamado_id',
        'autor_id',
        'is_system_log',
    ];

    protected $casts = [
        'is_system_log' => 'boolean', 
    ];

    /**
     * Define o relacionamento: Uma Atualização PERTENCE A um Chamado.
     */
    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }

    /**
     * Define o relacionamento: Uma Atualização PERTENCE A um Usuário (o autor).
     */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}