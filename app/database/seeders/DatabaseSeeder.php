<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// ✅ Importar los seeders
use Database\Seeders\ParcelsTableSeeder;
use Database\Seeders\ProductosTableSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Ejecutar seeders
        $this->call([
            ParcelsTableSeeder::class,
            ProductosSeeder::class,
        ]);

        // ✅ Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
