<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::firstOrCreate(
            ['nome' => 'Tecnologia da Informação'],
            ['local' => 'Tecnologia da Informação']
        );
        Departamento::firstOrCreate(
            ['nome' => 'Recursos Humanos'],
            ['local' => 'Prefeitura']
        );
    }
}
