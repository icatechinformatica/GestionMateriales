<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Directorio extends Model
{
    use Searchable;
    use HasFactory;
    protected $table = 'directorio';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'puesto', 'area_adscripcion_id', 'activo', 'qr_generado', 'numero_enlace', 'categoria'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'activo' => $this->activo
        ];
    }
}
