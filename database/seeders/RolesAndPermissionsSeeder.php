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

        Permission::firstOrCreate(['name' => 'roles-permissions']);

        // Prestamos
        Permission::firstOrCreate(['name' => 'pagar-prestamo']);
        Permission::firstOrCreate(['name' => 'eliminar-prestamo']);
        Permission::firstOrCreate(['name' => 'agregar-prestamo']);
        //Socios
        Permission::firstOrCreate(['name' => 'registro-socios']);
        Permission::firstOrCreate(['name' => 'actualizar-socio']);
        Permission::firstOrCreate(['name' => 'eliminar-socio']);
        Permission::firstOrCreate(['name' => 'agregar-socio']);
        Permission::firstOrCreate(['name' => 'buscar-socio']);

        //Aportes
        Permission::firstOrCreate(['name' => 'registro-aporte']);
        Permission::firstOrCreate(['name' => 'actualizar-aporte']);
        Permission::firstOrCreate(['name' => 'eliminar-aporte']);
        Permission::firstOrCreate(['name' => 'ver-total-aporte']);
        Permission::firstOrCreate(['name' => 'ver-pdf-aporte']);
        Permission::firstOrCreate(['name' => 'acciones-aporte']);
        Permission::firstOrCreate(['name' => 'buscar-aporte']);
        Permission::firstOrCreate(['name' => 'reporte-aporte']);
        Permission::firstOrCreate(['name' => 'buscar-por-ejecutivo-aportes']);
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userHelp = Role::firstOrCreate(['name' => 'userHelp']);
        $userAporte = Role::firstOrCreate(['name' => 'userAporte']);
        $userHelpAdmin = Role::firstOrCreate(['name' => 'userHelpAdmin']);
        // todos los permisos para el admin
        $allPermissionNames = Permission::pluck('name')->toArray();

        $adminRole->givePermissionTo($allPermissionNames);


        //permisos para userHelpAdmin
        $userHelpAdmin->givePermissionTo(['estado-cuenta']);
        $userHelpAdmin->givePermissionTo(['registro-aporte']);
        $userHelpAdmin->givePermissionTo(['aporte-ahorros']);
        $userHelpAdmin->givePermissionTo(['registro-aporte']);
        $userHelpAdmin->givePermissionTo(['agregar-prestamo']);
        $userHelpAdmin->givePermissionTo(['registro-socios']);
        $userHelpAdmin->givePermissionTo(['buscar-aporte']);
        $userHelpAdmin->givePermissionTo(['buscar-socio']);
        $userHelpAdmin->givePermissionTo(['agregar-socio']);
        $userHelpAdmin->givePermissionTo(['ver-pdf-aporte']);
        $userHelpAdmin->givePermissionTo(['ver-total-aporte']);
        $userHelpAdmin->givePermissionTo(['reporte-aporte']);




        // Permisos de usuario
        $userRole->givePermissionTo(['estado-cuenta']);
        $userRole->givePermissionTo(['aporte-ahorros']);


        $userHelp->givePermissionTo(['registro-socios']);
        $userAporte->givePermissionTo(['registro-aporte']);
        $userAporte->givePermissionTo(['aporte-ahorros']);

        // Crear usario admin
        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'CoopacLt$89',
        ]);
        $adminUser->assignRole($adminRole);

        // Crear usuario que solo accede a los permisos de registro de socios
        $userHelpUser = User::firstOrCreate([
            'email' => 'fabian_ramos@gmail.com'
        ], [
            'name' => 'Fabian Ramos',
            'email' => 'fabian_ramos@gmail.com',
            'password' => '41574501',
        ]);
        $userHelpUser->assignRole($userHelpAdmin);
        //.........2
        $userHelpUser2 = User::firstOrCreate([
            'email' => 'siomy_santur@gmail.com'
        ], [
            'name' => 'Siomy Esthefany Santur Rivera',
            'email' => 'siomy_santur@gmail.com',
            'password' => '73691992',
        ]);
        $userHelpUser2->assignRole($userHelpAdmin);
        //.........3
        $userHelpUser3 = User::firstOrCreate([
            'email' => 'yaned_mendoza@gmail.com'
        ], [
            'name' => 'Yaned Mendoza Huallanca',
            'email' => 'yaned_mendoza@gmail.com',
            'password' => '76353133',
        ]);
        $userHelpUser3->assignRole($userHelpAdmin);
        //.........4

        $userHelpUser4 = User::firstOrCreate([
            'email' => 'tany_zamora@gmail.com'
        ], [
            'name' => 'Tany lizeth Zamora Guevara',
            'email' => 'tany_zamora@gmail.com',
            'password' => '75058432',
        ]);
        $userHelpUser4->assignRole($userHelpAdmin);
        //.........5
        $userHelpUser5 = User::firstOrCreate([
            'email' => 'flor_ruiz@gmail.com'
        ], [
            'name' => 'Flor Dilma Ruiz Terrones',
            'email' => 'flor_ruiz@gmail.com',
            'password' => '76989248',
        ]);
        $userHelpUser5->assignRole($userHelpAdmin);
        //.........6
        $userHelpUser6 = User::firstOrCreate([
            'email' => 'vilma_diaz@gmail.com'
        ], [
            'name' => 'Vilma Diaz Rojas ',
            'email' => 'vilma_diaz@gmail.com',
            'password' => '75722880',
        ]);
        $userHelpUser6->assignRole($userHelpAdmin);
        //.........7
        $userHelpUser7 = User::firstOrCreate([
            'email' => 'luz_perez@gmail.com'
        ], [
            'name' => 'Luz Isela Pérez Carrasco',
            'email' => 'luz_perez@gmail.com',
            'password' => '73495924',
        ]);
        $userHelpUser7->assignRole($userHelpAdmin);
        //.........8
        $userHelpUser8 = User::firstOrCreate([
            'email' => 'vilma_lozada@gmail.com'
        ], [
            'name' => 'Vilma Emperatríz Lozada Vílchez',
            'email' => 'vilma_lozada@gmail.com',
            'password' => '71092688',
        ]);
        $userHelpUser8->assignRole($userHelpAdmin);
        //.........9
        $userHelpUser9 = User::firstOrCreate([
            'email' => 'vera_dira@gmail.com'
        ], [
            'name' => 'Dirá Chichipe Vera',
            'email' => 'vera_dira@gmail.com',
            'password' => '73125703',
        ]);
        $userHelpUser9->assignRole($userHelpAdmin);
        //.........10
        $userHelpUser10 = User::firstOrCreate([
            'email' => 'lesterwas5@gmail.com'
        ], [
            'name' => 'Issa Jenny Rubio Robles',
            'email' => 'lesterwas5@gmail.com',
            'password' => '44864790',
        ]);
        $userHelpUser10->assignRole($userHelpAdmin);
        //.........11
        $userHelpUser11 = User::firstOrCreate([
            'email' => 'sarahicojalperalta@gmail.com'
        ], [
            'name' => 'Sarahi Cojal Peralta',
            'email' => 'sarahicojalperalta@gmail.com',
            'password' => '74405136',
        ]);
        $userHelpUser11->assignRole($userHelpAdmin);
        //.........12
        $userHelpUser12 = User::firstOrCreate([
            'email' => 'kelynarro17@gmail.com'
        ], [
            'name' => 'Kely Narro',
            'email' => 'kelynarro17@gmail.com',
            'password' => '47834153',
        ]);
        $userHelpUser12->assignRole($userHelpAdmin);
        //.........13
        $userHelpUser13 = User::firstOrCreate([
            'email' => 'veradira1@gmail.com'
        ], [
            'name' => 'Dira Jhesafet Chichipe Vera',
            'email' => 'veradira1@gmail.com',
            'password' => '73125703',
        ]);
        $userHelpUser13->assignRole($userHelpAdmin);
        //.........14
        $userHelpUser13 = User::firstOrCreate([
            'email' => 'mdeysi742@gmail.com'
        ], [
            'name' => 'Milagros Deysi',
            'email' => 'mdeysi742@gmail.com',
            'password' => '73709191',
        ]);
        $userHelpUser13->assignRole($userHelpAdmin);
    }
}
