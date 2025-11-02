<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lectura;
use App\Models\Parcel;

class LecturaSeeder extends Seeder
{
    public function run(): void
    {
        $parcelas = Parcel::all();

        if ($parcelas->count() > 0) {
            foreach ($parcelas as $parcela) {
                // Crear 5 lecturas para cada parcela
                for ($i = 0; $i < 5; $i++) {
                    Lectura::create([
                        'parcel_id' => $parcela->id,
                        'temperatura' => rand(15, 35) + (rand(0, 99) / 100),
                        'humedad' => rand(50, 90) + (rand(0, 99) / 100),
                        'ph' => rand(5, 8) + (rand(0, 99) / 100),
                        'humedad_suelo' => rand(40, 80) + (rand(0, 99) / 100),
                        'tipo_sensor' => ['DHT22', 'DS18B20', 'BME280'][rand(0, 2)],
                        'notas' => 'Lectura automática generada',
                        'fecha_lectura' => now()->subDays(rand(0, 30))
                    ]);
                }
            }
        }
    }
}
