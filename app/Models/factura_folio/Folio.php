<?php

namespace App\Models\factura_folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\solicitud\CatalogoVehiculo;

class Folio extends Model
{
    use HasFactory;
    protected $table = 'folio';
    public $timestamps = true;

    protected $fillable = [
        'id', 'numero_folio', 'anio', 'documento', 'factura_id', 'denominacion', 'status', 'utilizado'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    // public function factura(): BelongsToMany
    // {
    //     return $this->belongsToMany(Factura::class, 'factura_folio', 'folio_id', 'factura_id');
    // }

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id');
    }

    public function catvehiculo(): BelongsToMany
    {
        return $this->belongsToMany(CatalogoVehiculo::class, 'vehiculo_folio', 'catalogo_vehiculo_id', 'folio_id')->withPivot('id','status', 'transitado');
    }
}
