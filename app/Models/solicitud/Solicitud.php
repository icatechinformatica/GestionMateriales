<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitud';
    public $timestamps = true;

    protected $fillable = [
        'id', 'catalogo_vehiculo_id', 'directorio_id', 'memorandum_comision', 'fecha', 'periodo', 'km_inicial',
        'numero_factura_compra', 'conductor', 'nombre_elabora', 'puesto_elabora', 'titular_departamento', 
        'km_final_antes_cargar_combustible',
        'km_inicial_cargar_combustible', 'total_km_recorridos', 'numero_economico', 'status_proceso', 'periodo_actual', 
        'anio_actual', 'litros_totales', 'importe_total', 'observacion', 'anio_solicitud', 'tipo_solicitud', 'es_comision',
        'pre_comision_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the catalogo_vehiculo that owns the Solicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalogo_vehiculo()
    {
        return $this->belongsTo(CatalogoVehiculo::class, 'catalogo_vehiculo_id', 'id');
    }

    /**
     * Get the user that owns the Solicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id', 'id');
    }

    /**
     * Get all of the seguimiento_solicitud for the Solicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seguimiento_solicitud()
    {
        return $this->hasMany(SeguimientoSolicitud::class, 'solicitud_id', 'id');
    }

    /**
     * Get all of the bitacora for the Solicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bitacora()
    {
        return $this->hasMany(Bitacora::class, 'solicitud_id', 'id');
    }

    /**
     * Get all of the factura for the Solicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function factura()
    {
        return $this->hasMany(Factura::class, 'solicitud_id', 'id');
    }
}
