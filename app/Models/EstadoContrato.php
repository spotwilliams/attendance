<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;


class EstadoContrato extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    const ESTADO_ACTIVO = 'ACTIVO';
    
    const ESTADO_BAJA = 'BAJA';
    
    const ESTADO_COMISION = 'COMISION';
    
    public $table = 'estado_contratos';
    
    public $notFoundMessage = 'El estado de contrato especificado es incorrecto.';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
        
        ];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'id_estado_contrato');
    }
    
    public function estadoPadreActivo()
    {
        return EstadoContrato::where('estado', EstadoContrato::ESTADO_ACTIVO)->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function padre()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_padre', 'id');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hijos()
    {
        return $this->hasMany(EstadoContrato::class, 'id_padre', 'id');
    }
    
    public function esActivo()
    {
        // Verificar que sea el estado padre activo
        if (strtolower($this->estado) === strtolower(EstadoContrato::ESTADO_ACTIVO)) {
            return true;
        } else {
            // Verificar que sea hijo de activo o alguno de sus hijos.
            $padre             = $this->padre()->first();
            $padreEstadoActivo = $this->estadoPadreActivo();
            
            if (($padre !== null) and ($padre->id === $padreEstadoActivo->id)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * @return Collection
     */
    public static function getEstadosEquivalentesBajas()
    {
        $estadoBajaPadre = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_BAJA)->first();
        
        return EstadoContrato::where('id', '=', $estadoBajaPadre->id)
            ->orWhere('id_padre', '=', $estadoBajaPadre->id)
            ->get();
        
    }
    
    /**
     * @return Collection
     */
    public static function getEstadosEquivalentesActivos()
    {
        $estadoActivoPadre = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)->first();
        
        return EstadoContrato::where('id', '=', $estadoActivoPadre->id)
            ->orWhere('id_padre', '=', $estadoActivoPadre->id)
            ->get();
        
    }
    
    /**
     * @return EstadoContrato
     */
    public static function comision()
    {
        return self::where('estado', '=', self::ESTADO_COMISION)->first();
    }
    protected function casts(): array
    {
        return ['deleted_at' => 'datetime'];
    }
}
