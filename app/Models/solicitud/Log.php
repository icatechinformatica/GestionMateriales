<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log';
    public $timestamps = true;

    protected $fillable = [
        'id', '	operacion', 'usuario', 'ip_request', 'mac_request', 'sistem_path', 'fecha_ejecucion',
        'hoarario_ejecucion', 'tipo_interaccion', 'tipo_peticion', 'contenido'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
