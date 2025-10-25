<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $path = database_path('seeders/data.sql');

        // 2. Ejecutar el contenido del archivo SQL
        // file_get_contents() lee todo el contenido del archivo en una cadena.
        // DB::unprepared() ejecuta la cadena como una consulta SQL "cruda".
        DB::unprepared(file_get_contents($path));

        // Opcional: Mostrar un mensaje en la consola
        $this->command->info('Archivo SQL ejecutado correctamente.');
    }
}
