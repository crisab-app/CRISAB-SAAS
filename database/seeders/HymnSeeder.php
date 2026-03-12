<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hymn;
use Illuminate\Support\Facades\Storage;

class HymnSeeder extends Seeder
{
    public function run(): void
    {
        // Buscamos el archivo en la carpeta storage/app
        $path = storage_path('app/himnario.csv');

        if (!file_exists($path)) {
            $this->command->error("¡No se encontró el archivo himnario.csv en storage/app!");
            return;
        }

        $file = fopen($path, "r");
        $firstline = true;

        while (($data = fgetcsv($file, 2000, ",")) !== FALSE) {
            // Saltamos la primera línea porque son los encabezados (HIMNO, NOMBRE, RITMO)
            if (!$firstline) {
                Hymn::create([
                    'number' => $data[0],
                    'title'  => $data[1],
                    'tune'   => $data[2] ?? null,
                ]);
            }
            $firstline = false;
        }

        fclose($file);
        $this->command->info("¡Himnario 'Celebremos su Gloria' importado con éxito! 🎶");
    }
}