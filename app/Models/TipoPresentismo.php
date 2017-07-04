<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class TipoPresentismo extends Model
{
    
    protected $table = 'tipos_presentismos';
    
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    const INJUSTIFICADO = 'A';
    const TARDANZA      = 'T';
    const PRESENTE      = 'P';
    
    protected $fillable
        = [
            'codigo',
            'descripcion',
            'color',
            'injustificado',
        ];
    
    protected $noJustificables
        = [
            'A',
        ];
    protected $noInjustificables
        = [
            'P',//Presente
            'F',//No laborable
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
    
    public static function tardanzas()
    {
        return TipoPresentismo::where('codigo', '=', TipoPresentismo::TARDANZA)->first();
    }
    
    public function esPresente()
    {
        return (strtoupper($this->codigo) === TipoPresentismo::PRESENTE);
    }
    
    /**
     * @return Ausente
     */
    public function getInjustificado()
    {
        return TipoPresentismo::where('codigo', '=', TipoPresentismo::INJUSTIFICADO)->first();
    }
    
    /**
     * @return bool
     */
    public function esInjustificado()
    {
        return ((strtoupper($this->codigo) === TipoPresentismo::INJUSTIFICADO) or ($this->injustificado == true));
    }
    
    public function puedoJustificarlo()
    {
        if (in_array($this->codigo, $this->noJustificables)) {
            // Significa que no puedo justificarlo
            return false;
        } else {
            return true;
        }
    }
    public function puedoInjustificarlo()
    {
        if (in_array($this->codigo, $this->noInjustificables)) {
            // Significa que no puedo justificarlo
            return false;
        } else {
            return true;
        }
    }
    
}