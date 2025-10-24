<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcel;

class ParcelsTableSeeder extends Seeder
{
    public function run()
    {
        Parcel::create([
            'name' => 'Parcela Central',
            'area' => 1.25,
            'crop' => 'Tomate',
            'latitude' => 10.1234567,
            'longitude' => -84.1234567,
            'notes' => 'Parcela de prueba.'
        ]);

        Parcel::create([
            'name' => 'Huerto Norte',
            'area' => 0.35,
            'crop' => 'Lechuga',
            'notes' => 'Riego manual.'
        ]);
    }
}
