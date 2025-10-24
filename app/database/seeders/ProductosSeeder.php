<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            DB::table('productos')->insert([
                'nombre' => "Producto $i",
                'descripcion' => "Descripción de prueba para Producto $i",
                'precio' => rand(100, 5000) / 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // XSS demo
        DB::table('productos')->insert([
            'nombre' => "XSS Demo",
            'descripcion' => "<script>alert('XSS almacenado')</script>",
            'precio' => 9.99,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
