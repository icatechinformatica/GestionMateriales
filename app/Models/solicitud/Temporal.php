<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Temporal extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'temporal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'catalogo_vehiculo_id', 'directorio_id', 'memorandum_comision', 'fecha', 'periodo', 'km_inicial',
        'numero_factura_compra', 'conductor', 'nombre_elabora', 'puesto_elabora', 'titular_departamento',
        'km_final_antes_cargar_combustible',
        'km_inicial_cargar_combustible', 'total_km_recorridos', 'numero_economico', 'status_proceso', 'periodo_actual',
        'anio_actual', 'litros_totales', 'importe_total', 'tipo_solicitud', 'rendimiento_litros', 'es_comision', 'observacion',
        'pre_comision_id', 'users_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the comments for the Temporal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bitacoracomisiontemporal(): HasMany
    {
        return $this->hasMany(BitacoraComisionTemporal::class, 'temporal_id', 'id');
    }

    /**
     * Get all of the comments for the Temporal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recorridocomisiontemporal(): HasMany
    {
        return $this->hasMany(RecorridoComisionTemporal::class, 'temporal_id', 'id');
    }

    public function bitacoratemporal(): HasMany
    {
        return $this->hasMany(BitacoraTemporal::class, 'solicitud_id', 'id');
    }
}
