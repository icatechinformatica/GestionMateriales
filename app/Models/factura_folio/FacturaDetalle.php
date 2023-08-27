<?php

namespace App\Models\factura_folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturaDetalle extends Model
{
    use HasFactory;
    protected $table = 'factura_detalles';
    public $timestamps = true;

    protected $fillable = [
        'id', '	factura_id', 'clave_producto', 'cantidad', 'clave_unidad', 'descripcion', 'valor_unitario', 'impuestos', 'importe'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the FacturaDetalle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facturas(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id');
    }
}
