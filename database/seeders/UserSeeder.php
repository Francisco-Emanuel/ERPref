<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setor;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pega o primeiro setor para associar ao admin.
        // Garanta que você tenha pelo menos um setor no banco.
        // Se não tiver, crie um Seeder para Setores também.
        $setor = Setor::first();
        if (!$setor) {
            $setor = Setor::create(['nome' => 'TI']);
        }

        // Cria o usuário Administrador padrão
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Procura por este email
            [ // Se não encontrar, cria com estes dados
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'setor_id' => $setor->id,
            ]
        );

        // Atribui o cargo 'Admin' a este usuário
        // Isso só funciona se o RolesAndPermissionsSeeder já tiver sido executado
        $adminUser->assignRole('Admin');
    }
}