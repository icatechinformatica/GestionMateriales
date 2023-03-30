<?php

namespace App\Models\factura_folio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Folio extends Model
{
    use HasFactory;
    protected $table = 'factura';
    public $timestamps = true;

    protected $fillable = [
        'id', '	numero_folio', 'anio', 'documento'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function factura(): BelongsToMany
    {
        return $this->belongsToMany(Factura::class);
    }
}
