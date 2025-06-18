<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa o cache de cargos e permissões
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // --- CRIAR PERMISSÕES ---
        // Permissões de Ativos
        Permission::create(['name' => 'view-ativos']);
        Permission::create(['name' => 'create-ativos']);
        Permission::create(['name' => 'edit-ativos']);
        Permission::create(['name' => 'delete-ativos']);

        // Permissões de Chamados
        Permission::create(['name' => 'view-chamados']);
        Permission::create(['name' => 'create-chamados']);
        Permission::create(['name' => 'edit-chamados']);
        Permission::create(['name' => 'close-chamados']);
        Permission::create(['name' => 'delete-chamados']);
        
        // Permissões de Usuários
        Permission::create(['name' => 'manage-users']);
        
        // Permissões de Sistema (Cargos, Setores, etc.)
        Permission::create(['name' => 'manage-system']);


        // --- CRIAR CARGOS ---
        $estagiario = Role::create(['name' => 'Estagiário']);
        $tecnico = Role::create(['name' => 'Técnico de TI']);
        $supervisor = Role::create(['name' => 'Supervisor']);
        $admin = Role::create(['name' => 'Admin']);


        // --- ATRIBUIR PERMISSÕES AOS CARGOS ---
        
        // Permissões do Estagiário
        $estagiario->givePermissionTo([
            'view-ativos', 'create-ativos', 'edit-ativos',
            'view-chamados', 'create-chamados', 'edit-chamados'
        ]);

        // Técnico de TI herda as permissões do Estagiário e ganha novas
        $tecnico->syncPermissions($estagiario->permissions);
        $tecnico->givePermissionTo(['close-chamados', 'delete-chamados']);

        // Supervisor herda as permissões do Técnico e ganha novas
        $supervisor->syncPermissions($tecnico->permissions);
        $supervisor->givePermissionTo(['manage-users']);

        // Admin tem todas as permissões
        $admin->givePermissionTo(Permission::all());
    }
}