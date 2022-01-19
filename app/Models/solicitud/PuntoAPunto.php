<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoAPunto extends Model
{
    use HasFactory;
    protected $table = 'punto_a_punto';
    public $timestamps = true;

    protected $fillable = [
        'id', '_de', '_a', 'peaje', 'pre_comision_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
