<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'area_adscripcion';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'organo_administrativo_id', 'clave_oficina'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
