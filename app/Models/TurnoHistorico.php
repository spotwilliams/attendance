<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class TurnoHistorico extends Model
{
    
    public $table = 'turnos_historicos';
    
    
    public $timestamps = false;
    
    public $fillable
        = [
            'id_operativo',
            'id_turno',
            'fecha_inicio',
            'fecha_fin',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'           => 'integer',
            'id_operativo' => 'integer',
            'id_turno'     => 'integer',
            'fecha_inicio' => 'date',
            'fecha_fin'    => 'date',
        ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
        
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function operativo()
    {
        return $this->belongsTo(Operativo::class, 'id_operativo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_operativo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turnosHistoricos()
    {
        return $this->hasMany(TurnoHistorico::class, 'id_turno_historico');
    }
}
