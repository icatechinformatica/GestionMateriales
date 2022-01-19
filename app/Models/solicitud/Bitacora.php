<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'solicitud_bitacora';
    public $timestamps = true;

    protected $fillable = [
        'id', 'solicitud_id', 'fecha', 'kilometraje_inicial', 'kilometraje_final', 'litros', 'division_vale',
        'importe', 'actividad_inicial', 'actividad_final', 'vales'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the solicitud that owns the Bitacora
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id', 'id');
    }
}
