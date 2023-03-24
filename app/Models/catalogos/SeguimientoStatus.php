<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoStatus extends Model
{
    use HasFactory;
    protected $table = 'seguimiento_status';
    public $timestamps = true;

    protected $fillable = [
        'id', 'estado'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
