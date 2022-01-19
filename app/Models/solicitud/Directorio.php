<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'directorio';
    public $timestamps = true;

    protected $fillable = [
        'id', '	nombre', 'apellido_paterno', 'apellido_materno', 'puesto', 'area_adscripcion_id', 'activo',
        'qr_generado', 'numero_enlace', 'categoria'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the solicitud for the Directorio
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitud(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'directorio_id', 'id');
    }
}
