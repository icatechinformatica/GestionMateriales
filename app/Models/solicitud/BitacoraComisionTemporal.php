<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraComisionTemporal extends Model
{
    use HasFactory;
    protected $table = 'bitacora_comision_temporal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'factura_comision', 'litros_comision', 'precio_unitario_comision', 'importe_comision', 'temporal_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the BitacoraComisionTemporal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function temporal(): BelongsTo
    {
        return $this->belongsTo(Temporal::class, 'temporal_id', 'id');
    }
}
