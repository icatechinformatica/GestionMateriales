<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreComision extends Model
{
    use HasFactory;

    protected $table = 'pre_comision';
    public $timestamps = true;

    protected $fillable = [
        'id', 'rendimiento', 'costo_combustible', 'placas_vehiculo', 'marca_vehiculo', 'km_totales', 'peaje',
        'monto_total', 'vehiculo_id', 'comisionado'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
