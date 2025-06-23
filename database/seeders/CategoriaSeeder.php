<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::firstOrCreate(
            ['tipo_interno' => 'ti'],
            ['nome_amigavel' => 'Suporte de TI']
        );

        Categoria::firstOrCreate(
            ['tipo_interno' => 'rh'],
            ['nome_amigavel' => 'Recursos Humanos']
        );
    }
}
