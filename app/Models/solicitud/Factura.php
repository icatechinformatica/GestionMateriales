<?php

namespace App\Models\solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'factura';
    public $timestamps = true;

    protected $fillable = [
        'id', 'solicitud_id', 'concepto', 'archivo', 'subtotal'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the solicitud that owns the Factura
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id', 'id');
    }
}
