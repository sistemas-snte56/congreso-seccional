<?php

namespace Database\Seeders;

use App\Models\Delegacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DelegacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/delegaciones.json');

        if (!File::exists($path)) {
            $this->command->warn('El archivo delegaciones.json no fue encontrado.');
            return;
        }

        // Leer y decodificar el JSON automáticamente a array de PHP
        $delegaciones = File::json($path);

        // Insertar en bloques de 500 para máximo rendimiento
        foreach (array_chunk($delegaciones, 500) as $chunk) {
            Delegacion::upsert($chunk, ['id'], ['region_id', 'delegacion', 'sede', 'nivel_id']);
        }

        $this->command->info('Delegaciones importadas desde JSON correctamente.');
    }
}
