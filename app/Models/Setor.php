<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    use HasFactory;
    protected $table = 'setores';

    protected $fillable = ['name'];

    // Um Setor tem muitos Usuários
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Um Setor tem muitos Ativos de TI
    public function ativos(): HasMany
    {
        return $this->hasMany(AtivoTI::class, 'setor_id');
    }
}