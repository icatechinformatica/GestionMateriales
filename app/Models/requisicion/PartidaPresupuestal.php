<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\requisicion\Requisicion;
use App\Models\requisicion\RequisicionUnidad;

class PartidaPresupuestal extends Model
{
    use HasFactory;
    protected $table = 'partida_presupuestal';
    public $timestamps = true;

    protected $fillable = [
        'id', 'id_requisicion', 'partida_presupuestal', 'concepto', 'id_partida'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the PartidaPresupuestal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class, 'id_requisicion', 'id');
    }

    /**
     * Get all of the comments for the PartidaPresupuestal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisicionunidad()
    {
        return $this->hasMany(RequisicionUnidad::class, 'id_partida_presupuestal', 'id');
    }
}
