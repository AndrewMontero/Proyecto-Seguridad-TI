<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'temperatura',
        'humedad',
        'ph',
        'humedad_suelo',
        'tipo_sensor',
        'notas',
        'fecha_lectura'
    ];

    protected $casts = [
        'fecha_lectura' => 'datetime',
        'temperatura' => 'decimal:2',
        'humedad' => 'decimal:2',
        'ph' => 'decimal:2',
        'humedad_suelo' => 'decimal:2',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
