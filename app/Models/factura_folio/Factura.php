<?php

namespace App\Models\factura_folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\catalogos\Proveedor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\factura_folio\FacturaDetalle;


class Factura extends Model
{
    use HasFactory;
    protected $table = 'factura';
    public $timestamps = true;

    protected $fillable = [
        'id', '	concepto', 'archivo', '	subtotal', 'cliente', 'serie', 'impuestos_trasladados', 'total',
        'certificado_emisor', 'fecha_emision', 'tipo_comprobante', 'certificado_sat', 'folio_fiscal', 'certificado_emisor',
        'id_catproveedor'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the invoices for the billing
     */
    // public function folios(): BelongsToMany
    // {
    //     return $this->belongsToMany(Folio::class, 'factura_folio', 'factura_id', 'folio_id')->withPivot('denominacion');
    // }

    public function folios(): HasMany
    {
        return $this->hasMany(Folio::class, 'factura_id', 'id');
    }

    /**
     * Get the resguardante that owns the CatalogoVehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedores(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_catproveedor', 'id');
    }

    /**
     * Get all of the comments for the Factura
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facturadetalles(): HasMany
    {
        return $this->hasMany(FacturaDetalle::class, 'factura_id', 'id');
    }

}
