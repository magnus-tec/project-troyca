<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::firstOrCreate(['name' => 'view-role']);
        Permission::firstOrCreate(['name' => 'create-role']);
        Permission::firstOrCreate(['name' => 'update-role']);
        Permission::firstOrCreate(['name' => 'delete-role']);

        Permission::firstOrCreate(['name' => 'view-permission']);
        Permission::firstOrCreate(['name' => 'create-permission']);
        Permission::firstOrCreate(['name' => 'update-permission']);
        Permission::firstOrCreate(['name' => 'delete-permission']);

        Permission::firstOrCreate(['name' => 'view-user']);
        Permission::firstOrCreate(['name' => 'create-user']);
        Permission::firstOrCreate(['name' => 'update-user']);
        Permission::firstOrCreate(['name' => 'delete-user']);

        Permission::firstOrCreate(['name' => 'estado-cuenta']);
        Permission::firstOrCreate(['name' => 'aporte-ahorros']);
        Permission::firstOrCreate(['name' => 'productos']);
        Permission::firstOrCreate(['name' => 'contacto']);

        // Prestamos
        Permission::firstOrCreate(['name' => 'pagar-prestamo']);
        Permission::firstOrCreate(['name' => 'eliminar-prestamo']);
        Permission::firstOrCreate(['name' => 'agregar-prestamo']);
        //Socios
        Permission::firstOrCreate(['name' => 'registro-socios']);
        Permission::firstOrCreate(['name' => 'actualizar-socio']);
        Permission::firstOrCreate(['name' => 'eliminar-socio']);
        //Aportes
        Permission::firstOrCreate(['name' => 'registro-aporte']);
        Permission::firstOrCreate(['name' => 'actualizar-aporte']);
        Permission::firstOrCreate(['name' => 'eliminar-aporte']);

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userHelp = Role::firstOrCreate(['name' => 'userHelp']);
        // todos los permisos para el admin
        $allPermissionNames = Permission::pluck('name')->toArray();

        $adminRole->givePermissionTo($allPermissionNames);


        // Permisos de usuario
        $userRole->givePermissionTo(['estado-cuenta']);
        $userRole->givePermissionTo(['aporte-ahorros']);

        $userHelp->givePermissionTo(['registro-socios']);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'CoopacLt$89',
        ]);
        $adminUser->assignRole($adminRole);

        $userHelpUser = User::firstOrCreate([
            'email' => 'fabian_ramos@gmail.com'
        ], [
            'name' => 'Fabian Ramos',
            'email' => 'fabian_ramos@gmail.com',
            'password' => '41574501',
        ]);
        $userHelpUser->assignRole($userHelp);
    }
}
