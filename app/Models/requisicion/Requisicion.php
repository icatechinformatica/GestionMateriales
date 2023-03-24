<?php

namespace App\Models\requisicion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\solicitud\Area;
use App\Models\requisicion\RequisicionUnidad;
use App\Models\requisicion\Momorandum;
use App\Models\requisicion\PartidaPresupuestal;

class Requisicion extends Model
{
    use HasFactory;
    protected $table = 'requisicion';
    public $timestamps = true;

    protected $fillable = [
        'id', 'fechaRequisicion', 'solicita', 'autoriza', 'id_area', 'departamento', 'id_estado', 'justificacion'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * requisicion pertenece
     */
    /**
     * Get the solicitud that owns the Factura
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(){
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }
    
    /**
     * Get the user associated with the Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function memorandum()
    {
        return $this->hasOne(Momorandum::class, 'id_requisicion', 'id');
    }

    /**
     * Get all of the comments for the Requisicion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidapresupuestal()
    {
        return $this->hasMany(PartidaPresupuestal::class, 'id_requisicion', 'id');
    }
}
