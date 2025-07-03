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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function ativos(): HasMany
    {
        return $this->hasMany(AtivoTI::class, 'departamento_id');
    }

    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class);
    }
}