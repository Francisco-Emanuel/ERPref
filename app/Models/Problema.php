<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Problema extends Model
{
    use HasFactory;

    /**
     * O nome da tabela. Laravel provavelmente adivinharia 'problemas' corretamente,
     * mas é uma boa prática especificar para evitar erros de pluralização.
     */
    protected $table = 'problemas';

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'descricao',
        'solucao',
        'ativo_ti_id',
        'autor_id',
    ];

    /**
     * Define o relacionamento: Um Problema PERTENCE A um Ativo de TI.
     */
    public function ativo(): BelongsTo
    {
        return $this->belongsTo(AtivoTI::class, 'ativo_ti_id');
    }

    /**
     * Define o relacionamento: Um Problema PERTENCE A um Usuário (o autor).
     */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    /**
     * Define o relacionamento: Um Problema PODE TER UM Chamado associado a ele.
     */
    public function chamado(): HasOne
    {
        return $this->hasOne(Chamado::class);
    }
}