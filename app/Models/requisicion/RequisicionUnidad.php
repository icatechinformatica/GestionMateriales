<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\requisicion\Requisicion;
use App\Models\requisicion\PartidaPresupuestal;

class RequisicionUnidad extends Model
{
    use HasFactory;
    protected $table = 'requisicion_unidad';
    public $timestamps = true;

    protected $fillable = [
        'id', 'cantidad', 'unidad', 'descripcion', 'justificacion', 'id_partida_presupuestal'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Get the user that owns the RequisicionUnidad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partidapresupuestal()
    {
        return $this->belongsTo(PartidaPresupuestal::class, 'id_partida_presupuestal', 'id');
    }
}
