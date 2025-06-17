<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtivoTI extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * O nome da tabela associada com o model.
     * Laravel tentaria 'ativo_t_i_s', então especificamos o nome correto.
     * @var string
     */
    protected $table = 'ativos_ti';

    /**
     * Os atributos que podem ser atribuídos em massa.
     * (Todos os campos do seu formulário)
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_ativo',
        'numero_serie',
        'tipo_ativo',
        'status_condicao',
        'descricao_problema',
        'user_id', 
        'setor_id',
        'visible',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     * Garante que 'visible' seja sempre true/false.
     * @var array<string, string>
     */
    protected $casts = [
        'visible' => 'boolean',
    ];

    /**
     * Define o relacionamento: Um AtivoTI pertence a um Usuário (Responsável).
     */
    public function responsavel(): BelongsTo
    {
        // O segundo argumento ('user_id') é a chave estrangeira nesta tabela (ativos_ti)
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define o relacionamento: Um AtivoTI pertence a um Setor.
     */
    public function setor(): BelongsTo
    {
        // Laravel assume a chave 'setor_id' por convenção, então não precisamos especificá-la
        return $this->belongsTo(Setor::class);
    }
}
