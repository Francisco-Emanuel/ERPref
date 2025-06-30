<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Resetar os papéis e permissões em cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- DEFINIÇÃO DE PERMISSÕES ---
        $permissions = [
            'view-ativos', 'create-ativos', 'edit-ativos', 'delete-ativos',
            'view-chamados', 'create-chamados', 'edit-chamados', 'close-chamados',
            'view-users', 'create-users', 'edit-users', 'delete-users',
            'view-departamentos', 'create-departamentos', 'edit-departamentos', 'delete-departamentos',
            'view-categorias', 'create-categorias', 'edit-categorias', 'delete-categorias',
        ];

        foreach ($permissions as $permission) {
            // Usa firstOrCreate para evitar duplicatas
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- DEFINIÇÃO DE PAPÉIS E ATRIBUIÇÃO DE PERMISSÕES ---

        // Papel: Usuário Comum (pode ver e criar chamados)
        $roleComum = Role::firstOrCreate(['name' => 'Usuário Comum']);
        $roleComum->givePermissionTo(['view-chamados', 'create-chamados']);

        // Papel: Estagiário (pode ver ativos e se atribuir a chamados)
        $roleEstagiario = Role::firstOrCreate(['name' => 'Estagiário']);
        $roleEstagiario->givePermissionTo(['view-ativos', 'view-chamados', 'edit-chamados']);

        // Papel: Técnico de TI (pode gerir chamados e ativos)
        $roleTecnico = Role::firstOrCreate(['name' => 'Técnico de TI']);
        $roleTecnico->givePermissionTo([
            'view-ativos', 'create-ativos', 'edit-ativos',
            'view-chamados', 'create-chamados', 'edit-chamados', 'close-chamados',
        ]);

        // Papel: Supervisor (pode gerir tudo, exceto usuários)
        $roleSupervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $roleSupervisor->givePermissionTo([
            'view-ativos', 'create-ativos', 'edit-ativos', 'delete-ativos',
            'view-chamados', 'create-chamados', 'edit-chamados', 'close-chamados',
            'view-departamentos', 'create-departamentos', 'edit-departamentos', 'delete-departamentos',
            'view-categorias', 'create-categorias', 'edit-categorias', 'delete-categorias',
        ]);

        // Papel: Admin (tem todas as permissões)
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all());
    }
}