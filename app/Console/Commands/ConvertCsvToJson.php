<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertCsvToJson extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     */
    protected $signature = 'csv:to-json';

    /**
     * La descripción del comando.
     */
    protected $description = 'Convierte los archivos CSV de regiones a formato JSON automáticamente';

    /**
     * Ejecutar el comando de consola.
     */
    public function handle(): void
    {
        // Lista de archivos que deseas convertir
        $archivos = ['regiones', 'delegaciones', 'niveles'];
        $dataPath = database_path('seeders/data');

        foreach ($archivos as $nombreArchivo) {
            $csvPath = "{$dataPath}/{$nombreArchivo}.csv";
            $jsonPath = "{$dataPath}/{$nombreArchivo}.json";

            if (!File::exists($csvPath)) {
                $this->warn("El archivo {$nombreArchivo}.csv no fue encontrado en {$dataPath}. Se omite.");
                continue;
            }

            // Leer todas las líneas del CSV
            $filas = file($csvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (empty($filas)) {
                $this->warn("El archivo {$nombreArchivo}.csv está vacío.");
                continue;
            }

            // Extraer la cabecera (primera línea) y limpiarla de posibles caracteres extraños (como BOM de UTF-8)
            $cabecera = str_getcsv(array_shift($filas));
            $cabecera[0] = preg_replace('/^\xEF\xBB\xBF/', '', $cabecera[0]);

            $datos = [];

            // Recorrer el resto de las filas para combinarlas con la cabecera
            foreach ($filas as $fila) {
                $valores = str_getcsv($fila);
                
                // Asegurarse de que la fila tenga el mismo número de columnas que la cabecera
                if (count($cabecera) === count($valores)) {
                    $datos[] = array_combine($cabecera, $valores);
                }
            }

            // Guardar en formato JSON bonito y legible
            File::put($jsonPath, json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $this->info("¡Convertido con éxito: {$nombreArchivo}.csv -> {$nombreArchivo}.json!");
        }

        $this->line("\n¡Proceso de conversión finalizado!");
    }
}