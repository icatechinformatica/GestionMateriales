<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resguardante extends Model
{
    use HasFactory;
    protected $table = 'resguardante';
    public $timestamps = true;

    protected $fillable = [
        'id', 'resguardante_unidad', 'puesto_resguardante_unidad', 'area_adscripcion_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the catalogo_vehiculo for the Resguardante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogo_vehiculo(): HasMany
    {
        return $this->hasMany(CatalogoVehiculo::class, 'resguardante_id', 'id');
    }
}
