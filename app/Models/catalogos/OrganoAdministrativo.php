<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganoAdministrativo extends Model
{
    use HasFactory;
    protected $table = 'organo_administrativo';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'descripcion'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
