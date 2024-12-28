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
        Permission::create(['name' => 'view-role']);
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'update-role']);
        Permission::create(['name' => 'delete-role']);

        Permission::create(['name' => 'view-permission']);
        Permission::create(['name' => 'create-permission']);
        Permission::create(['name' => 'update-permission']);
        Permission::create(['name' => 'delete-permission']);

        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'estado-cuenta']);
        Permission::create(['name' => 'aporte-ahorros']);
        Permission::create(['name' => 'productos']);
        Permission::create(['name' => 'contacto']);

        // Prestamos
        Permission::create(['name' => 'pagar-prestamo']);
        Permission::create(['name' => 'eliminar-prestamo']);
        //Socios
        Permission::create(['name' => 'registro-socios']);
        Permission::create(['name' => 'actualizar-socio']);
        Permission::create(['name' => 'eliminar-socio']);


        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // todos los permisos para el admin
        $allPermissionNames = Permission::pluck('name')->toArray();

        $adminRole->givePermissionTo($allPermissionNames);


        // Permisos de usuario
        $userRole->givePermissionTo(['estado-cuenta']);
        $userRole->givePermissionTo(['aporte-ahorros']);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);

        $adminUser->assignRole($adminRole);

        $user = User::firstOrCreate([
            'email' => 'user@gmail.com'
        ], [
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => '12345678',
        ]);

        $user->assignRole($userRole);
    }
}
