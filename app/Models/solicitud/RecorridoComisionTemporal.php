<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecorridoComisionTemporal extends Model
{
    use HasFactory;
    protected $table = 'recorrido_comision_temporal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'fecha_comision', 'de_comision', 'a_comision', 'temporal_id', 'tipo'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the solicitud that owns the Bitacora
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function temporal(): BelongsTo
    {
        return $this->belongsTo(Temporal::class, 'temporal_id', 'id');
    }
}
