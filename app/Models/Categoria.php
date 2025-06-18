<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    // Laravel adivinha o nome da tabela 'categorias' corretamente,
    // mas é uma boa prática ser explícito para evitar erros.
    protected $table = 'categorias';

    // Define os campos que podem ser preenchidos em massa.
    protected $fillable = ['nome_amigavel', 'tipo_interno'];

    // Define a relação: Uma Categoria pode ter muitos Chamados
    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class);
    }
}