<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraTemporal extends Model
{
    use HasFactory;

    protected $table = 'bitacora_temporal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'solicitud_id', 'fecha', 'kilometraje_inicial', 'kilometraje_final', 'litros', 'division_vale',
        'importe', 'actividad_inicial', 'actividad_final', 'vales'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
