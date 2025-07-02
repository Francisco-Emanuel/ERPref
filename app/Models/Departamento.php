<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;
    protected $table = 'departamentos';

    protected $fillable = ['nome', 'local'];

    // Um departamento tem muitos Usuários
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Um departamento tem muitos Ativos de TI
    public function ativos(): HasMany
    {
        return $this->hasMany(AtivoTI::class, 'departamento_id');
    }

    // Um departamento tem muitos chamados
    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class);
    }
}