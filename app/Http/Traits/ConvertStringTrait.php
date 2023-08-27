<?php

namespace App\Http\Traits;
use Illuminate\Support\Str;

/**
 * código reutilizable que nos ayudará a convertir cualquier cadena a mayúscula
 */
trait ConvertStringTrait
{
    public function toUpper($str){
        return mb_strtoupper(trim($str), 'utf-8');
    }
}
