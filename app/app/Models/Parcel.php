<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parcel extends Model
{
    protected $table = 'parcels';

    protected $fillable = [
        'user_id',
        'name',
        'area',
        'crop',
        'latitude',
        'longitude',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
