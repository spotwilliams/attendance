<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoHistorico extends Model
{
    use HasFactory;

    public $table = 'contratos_historicos';
    
    public $timestamps = false;
    
    public $fillable
        = [
            'id_tipo_contrato',
            'id_estado_contrato',
            'id_agente',
            'fecha_ingreso',
            'fecha_ingreso_gobierno',
            'fecha_fin',
            'fecha_estado_desde',
            'fecha_estado_hasta',
            'id_sial',
            'ficha',
            'tipo_inscripcion',
            'comentario',
            'monto',
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
    public function estadoContrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_estado_contrato', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'id_tipo_contrato');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    /**
     * The attributes that should be casted to native types.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'id'                     => 'integer',
            'id_tipo_contrato'       => 'integer',
            'id_estado_contrato'     => 'integer',
            'id_agente'              => 'integer',
            'fecha_ingreso'          => 'date',
            'fecha_ingreso_gobierno' => 'date',
            'fecha_fin'              => 'date',
            'fecha_estado_desde'     => 'date',
            'fecha_estado_hasta'     => 'date',
            'id_sial'                => 'string',
            'ficha'                  => 'string',
            'tipo_inscripcion'       => 'string',
            'comentario'             => 'string',
        ];
    }
}
