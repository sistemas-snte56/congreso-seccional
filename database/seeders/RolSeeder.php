<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos los roles esenciales para el Congreso de la Sección 56
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $capturistaRole = Role::firstOrCreate(['name' => 'capturista']);
        $dictaminadorRole = Role::firstOrCreate(['name' => 'dictaminador']);
        $operadorRole = Role::firstOrCreate(['name' => 'operador_entrada']);

        // 2. Buscamos o asignamos el rol al primer usuario (Administrador general)
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole($adminRole);
        }

        // 3. Crear un usuario de prueba para la Comisión Dictaminadora
        $dictaminador = User::firstOrCreate(
            ['email' => 'dictaminador@email.com'],
            [
                'name' => 'Comisión Dictaminadora',
                'password' => Hash::make('password2026'),
            ]
        );
        $dictaminador->assignRole($dictaminadorRole);

        // 4. Crear un usuario de prueba para Captura
        $capturista = User::firstOrCreate(
            ['email' => 'capturista@email.com'],
            [
                'name' => 'Capturista Seccional',
                'password' => Hash::make('password2026'),
            ]
        );
        $capturista->assignRole($capturistaRole);
        
        // 5. Crear un usuario de prueba para la Mesa de Entrada (Check-in)
        $operador = User::firstOrCreate(
            ['email' => 'mesaentrada@email.com'],
            [
                'name' => 'Operador Mesa de Entrada',
                'password' => Hash::make('password2026'),
            ]
        );
        $operador->assignRole($operadorRole);
    }
}