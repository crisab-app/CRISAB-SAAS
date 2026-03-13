<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class BibleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiamos nuestra tabla definitiva
        DB::table('bible_verses')->truncate();

        // 2. Buscamos el archivo SQL
        $path = database_path('seeders/rv60.sql');
        if (!file_exists($path)) {
            $this->command->error("¡No se encontró el archivo rv60.sql en la carpeta seeders!");
            return;
        }

        $this->command->info("Preparando la base de datos...");

        // 3. Creamos la tabla temporal
        Schema::dropIfExists('bible_rv60');
        Schema::create('bible_rv60', function (Blueprint $table) {
            $table->integer('book');
            $table->integer('chapter');
            $table->integer('verse');
            $table->text('text');
        });

        $this->command->info("Extrayendo versículos de forma segura...");

        // 4. Leemos el archivo línea por línea (¡Adiós errores de puntos y comas!)
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $query = '';
        $isInserting = false;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            // Detectamos dónde empieza un bloque de inserción
            if (str_starts_with($trimmed, 'INSERT INTO `bible_rv60`')) {
                $isInserting = true;
            }

            if ($isInserting) {
                $query .= $line . "\n";
                // Sabemos que el bloque termina cuando la línea finaliza con ");"
                if (str_ends_with($trimmed, ');')) {
                    DB::unprepared($query);
                    $query = '';
                    $isInserting = false;
                }
            }
        }

        $this->command->info("Traduciendo números de libros a texto...");

        // 5. Diccionario de traducción de los 66 libros
        $books = [
            1 => 'Génesis', 2 => 'Éxodo', 3 => 'Levítico', 4 => 'Números', 5 => 'Deuteronomio',
            6 => 'Josué', 7 => 'Jueces', 8 => 'Rut', 9 => '1 Samuel', 10 => '2 Samuel',
            11 => '1 Reyes', 12 => '2 Reyes', 13 => '1 Crónicas', 14 => '2 Crónicas', 15 => 'Esdras',
            16 => 'Nehemías', 17 => 'Ester', 18 => 'Job', 19 => 'Salmos', 20 => 'Proverbios',
            21 => 'Eclesiastés', 22 => 'Cantares', 23 => 'Isaías', 24 => 'Jeremías', 25 => 'Lamentaciones',
            26 => 'Ezequiel', 27 => 'Daniel', 28 => 'Oseas', 29 => 'Joel', 30 => 'Amós',
            31 => 'Abdías', 32 => 'Jonás', 33 => 'Miqueas', 34 => 'Nahúm', 35 => 'Habacuc',
            36 => 'Sofonías', 37 => 'Hageo', 38 => 'Zacarías', 39 => 'Malaquías', 40 => 'Mateo',
            41 => 'Marcos', 42 => 'Lucas', 43 => 'Juan', 44 => 'Hechos', 45 => 'Romanos',
            46 => '1 Corintios', 47 => '2 Corintios', 48 => 'Gálatas', 49 => 'Efesios', 50 => 'Filipenses',
            51 => 'Colosenses', 52 => '1 Tesalonicenses', 53 => '2 Tesalonicenses', 54 => '1 Timoteo', 55 => '2 Timoteo',
            56 => 'Tito', 57 => 'Filemón', 58 => 'Hebreos', 59 => 'Santiago', 60 => '1 Pedro',
            61 => '2 Pedro', 62 => '1 Juan', 63 => '2 Juan', 64 => '3 Juan', 65 => 'Judas',
            66 => 'Apocalipsis'
        ];

        // 6. Pasamos los datos a nuestra tabla definitiva
        foreach ($books as $id => $name) {
            DB::insert("
                INSERT INTO bible_verses (book_name, chapter, verse, text, created_at, updated_at)
                SELECT ?, chapter, verse, text, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                FROM bible_rv60 
                WHERE book = ?
            ", [$name, $id]);
        }

        // 7. Destruimos la tabla temporal
        Schema::dropIfExists('bible_rv60');

        $this->command->info("¡Biblia Reina Valera 1960 importada con éxito! 📖⚡");
    }
}