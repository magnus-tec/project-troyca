<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MagusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Buscar o crear el rol admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear usuario Magus
        $user = User::firstOrCreate(
            ['email' => 'magus@gmail.com'],
            [
                'name' => 'Magus',
                'password' => Hash::make('c4p1cu4%%2060'),
            ]
        );

        // Asignar rol
        $user->assignRole($adminRole);
    }
}
