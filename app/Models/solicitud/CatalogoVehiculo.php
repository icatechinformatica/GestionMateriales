<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\factura_folio\Folio;

class CatalogoVehiculo extends Model
{
    use HasFactory;

    protected $table = 'catalogo_vehiculo';
    public $timestamps = true;

    protected $fillable = [
        'id', 'color', 'numero_motor', 'marca', 'modelo', 'tipo', 'placas',
        'numero_serie', 'resguardante_id', 'numero_economico', 'km_final',
        'importe_combustible', 'rendimiento_ciudad', 'rendimiento_carreteta', 'rendimiento_mixto',
        'rendimiento_carga',
        'km_inicial'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the solicitud for the CatalogoVehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitud(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'catalogo_vehiculo_id', 'id');
    }

    /**
     * Get the resguardante that owns the CatalogoVehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resguardante(): BelongsTo
    {
        return $this->belongsTo(Resguardante::class, 'resguardante_id', 'id');
    }

    public function folio(): BelongsToMany
    {
        return $this->belongsToMany(Folio::class, 'vehiculo_folio', 'catalogo_vehiculo_id', 'folio_id')->withPivot('id','status', 'transitado');
    }
}
