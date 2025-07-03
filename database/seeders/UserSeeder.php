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
        $departamentoTI = Departamento::firstOrCreate(['nome' => 'Tecnologia da Informação'], ['local'=> 'Tecnologia da Informação']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], 
            [ 
                'name' => 'Administrador',
                'password' => Hash::make('Ti@2025'),
                'email_verified_at' => now(),
                'departamento_id' => $departamentoTI->id,
            ]
        );

        $adminUser->assignRole('Admin');
    }
}