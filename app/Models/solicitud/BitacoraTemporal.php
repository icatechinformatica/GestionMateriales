<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitacoraTemporal extends Model
{
    use HasFactory;

    protected $table = 'bitacora_temporal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'solicitud_id', 'fecha', 'kilometraje_inicial', 'kilometraje_final', 'litros', 'division_vale',
        'importe', 'actividad_inicial', 'actividad_final', 'vales', 'importevales', 'numero_comision', 'comision',
        'confirmado'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function temporal(): BelongsTo
    {
        return $this->belongsTo(Temporal::class, 'solicitud_id', 'id');
    }
}
