<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/regiones.json');

        if (!File::exists($path)) {
            $this->command->warn('El archivo regiones.json no fue encontrado.');
            return;
        }

        // Leer y decodificar el JSON automáticamente a array de PHP
        $regiones = File::json($path);

        // Insertar en bloques de 500 para máximo rendimiento
        foreach (array_chunk($regiones, 500) as $chunk) {
            Region::upsert($chunk, ['id'], ['nombre']);
        }

        $this->command->info('Regiones importadas desde JSON correctamente.');
    }
}
