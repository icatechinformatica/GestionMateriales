<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\requisicion\Requisicion;

class Momorandum extends Model
{
    use HasFactory;
    protected $table = 'memorandum';
    public $timestamps = true;

    protected $fillable = [
        'id', 'memorandum', 'contenido', 'id_requisicion', 'cargado'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the Momorandum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class, 'id_requisicion');
    }
}
