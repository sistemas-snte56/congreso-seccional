<?php

namespace Database\Seeders;

use App\Models\Nivel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/niveles.json');

        if (!File::exists($path)) {
            $this->command->warn('El archivo niveles.json no fue encontrado.');
            return;
        }

        // Leer y decodificar el JSON automáticamente a array de PHP
        $niveles = File::json($path);

        // Insertar en bloques de 500 para máximo rendimiento
        foreach (array_chunk($niveles, 500) as $chunk) {
            Nivel::upsert($chunk, ['id'], ['nombre']);
        }

        $this->command->info('Niveles importados desde JSON correctamente.');
    }
}
