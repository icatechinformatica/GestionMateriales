<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'choferes';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'area_adscripcion_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
