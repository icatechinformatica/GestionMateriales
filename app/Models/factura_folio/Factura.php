<?php

namespace App\Models\factura_folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'factura';
    public $timestamps = true;

    protected $fillable = [
        'id', '	concepto', 'archivo', '	subtotal', 'cliente', 'serie', 'impuestos_trasladados', 'total'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the invoices for the billing
     */
    public function folios(): BelongsToMany
    {
        return $this->belongsToMany(Folio::class, 'factura_folio', 'factura_id', 'folio_id');
    }

}
