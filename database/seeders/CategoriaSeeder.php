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
            ['tipo_interno' => 'Hardware'],
            ['nome_amigavel' => 'Computador/impressora/internet']
        );

        Categoria::firstOrCreate(
            ['tipo_interno' => 'Software'],
            ['nome_amigavel' => 'Programa específico/Office']
        );
    }
}
