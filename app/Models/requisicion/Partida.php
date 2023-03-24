<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;
    protected $table = 'partida';
    public $timestamps = true;

    protected $fillable = [
        'id', 'descripcion', 'clave_partida'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function producto(){
        return $this->hasMany(Producto::class, 'id', 'id_partida');
    }

}
