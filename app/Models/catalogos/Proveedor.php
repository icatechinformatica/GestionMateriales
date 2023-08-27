<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\factura_folio\Factura;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'catalogo_proveedor';
    public $timestamps = true;

    protected $fillable = [
        'id', 'nombre', 'propietario', 'rfc', 'regimen', 'direccion', 'lugar_expedicion',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get all of the solicitud for the CatalogoVehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class, 'id_catproveedor', 'id');
    }
}
