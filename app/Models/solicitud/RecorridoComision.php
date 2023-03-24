<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecorridoComision extends Model
{
    use HasFactory;

    protected $table = 'recorrido_comision';
    public $timestamps = true;

    protected $fillable = [
        'id', 'fecha_comision', 'de_comision', 'a_comision', 'solicitud_id', 'tipo'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
