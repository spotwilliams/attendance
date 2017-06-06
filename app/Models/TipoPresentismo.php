<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class TipoPresentismo extends Model
{
    
    protected $table = 'tipos_presentismos';
    
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    const INJUSTIFICADO = 'INJUSTIFICADO';
    const PRESENTE      = 'PRESENTE';
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'              => 'integer',
            'dias_permitidos' => 'integer',
            'id_padre'        => 'integer',
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
    public function presentismos()
    {
        return $this->hasMany(Presentismo::class, 'id_tipo_presentismo', 'id');
    }
    
    public function diasPermitidos()
    {
        return $this->hasMany(DiaPermitido::class, 'id_tipo_presentismo');
    }
    
    /**
     * Devuelve el model para el caso Injustificado
     * @return TipoPresentismo
     */
    public static function injusticado()
    {
        return TipoPresentismo::where('codigo', '=', TipoPresentismo::INJUSTIFICADO)->first();
    }
    
    public function esPresente()
    {
        return (strtoupper($this->codigo) === TipoPresentismo::PRESENTE);
    }
}