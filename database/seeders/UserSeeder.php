<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pega o primeiro departamento para associar ao admin.
        // Garanta que você tenha pelo menos um departamento no banco.
        // Se não tiver, crie um Seeder para departamentoes também.
        $departamentoTI = Departamento::firstOrCreate(['nome' => 'Tecnologia da Informação'], ['local'=> 'Tecnologia da Informação']);

        // Cria o usuário Administrador padrão
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Procura por este email
            [ // Se não encontrar, cria com estes dados
                'name' => 'Administrador',
                'password' => Hash::make('Y]uqsn0.'),
                'email_verified_at' => now(),
                'departamento_id' => $departamentoTI->id,
            ]
        );

        // Atribui o cargo 'Admin' a este usuário
        // Isso só funciona se o RolesAndPermissionsSeeder já tiver sido executado
        $adminUser->assignRole('Admin');
    }
}