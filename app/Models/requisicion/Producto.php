<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'clave', 'descripcion', 'existencia', 'minimo', 'unidad_medida', 'precio', 'id_partida'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function partida(){
        return $this->belongsTo(Partida::class, 'id_partida', 'id');
    }

    /**
     * The roles that belong to the Producto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requisiciones(): BelongsToMany
    {
        return $this->belongsToMany(Requisicion::class, 'requisicion_producto', 'id_requisicion', 'id_producto');
    }
}
