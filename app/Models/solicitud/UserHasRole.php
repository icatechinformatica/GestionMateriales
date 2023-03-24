<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasRole extends Model
{
    use HasFactory;
    protected $table = 'model_has_roles';
    public $timestamps = true;

    protected $fillable = ['role_id', 'model_type', 'model_id'];
}
