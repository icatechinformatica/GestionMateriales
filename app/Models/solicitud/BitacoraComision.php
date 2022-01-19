<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraComision extends Model
{
    use HasFactory;
    protected $table = 'bitacora_comision';
    public $timestamps = true;

    protected $fillable = [
        'id', 'factura_comision', 'litros_comision', 'precio_unitario_comision', 'importe_comision', 'solicitud_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
