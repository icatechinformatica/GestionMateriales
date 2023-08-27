<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denominaciones extends Model
{
    use HasFactory;
    protected $table = 'denominaciones_vales';
    public $timestamps = true;

    protected $fillable = [
        'id', 'denominacion', 'valor',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
