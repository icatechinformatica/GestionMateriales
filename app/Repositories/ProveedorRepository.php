<?php

namespace App\Repositories;
use App\Models\catalogos\Proveedor;
use App\Interfaces\ProveedorRepositoryInterface;

class ProveedorRepository implements ProveedorRepositoryInterface {

    public function proveedoresAll(){
        /**
         * OBTENEMOS TODOS LOS PROVEEDORES CON SÓLO NOMBRE E ID
         */
        return Proveedor::pluck('nombre', 'id');
    }
}
