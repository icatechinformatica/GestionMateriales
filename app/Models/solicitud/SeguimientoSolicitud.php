<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoSolicitud extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seguimiento_solicitud';
    public $timestamps = true;

    protected $fillable = [
        'id', 'solicitud_id', 'status_seguimiento_id', 'fecha_inicio', 'fecha_fin', 'tiempo_solicitud'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the SeguimientoSolicitud
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}
