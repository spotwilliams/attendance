<?php

namespace Cat\Modules\Haberes\Services\Registro;

use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CierrePeriodo extends Service
{
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var Base */
    protected $base;
    
    /** @var Base */
    protected $turno;
    
    public function __construct(Periodo $periodo, Base $base, Turno $turno)
    {
        $this->periodo = $periodo;
        $this->base    = $base;
        $this->turno   = $turno;
    }
    
    
    public function execute()
    {
        
        try {
            
            DB::beginTransaction();
            
            /** @var EstadoPeriodo $estadoPeriodo */
            
            $estadoPeriodo = EstadoPeriodo::where('id_periodo', '=', $this->periodo->id)
                ->where('id_base', '=', $this->base->id)
                ->where('id_turno', '=', $this->turno->id)
                ->firstOrFail();
            
            $estadoPeriodo->abierto = 0;
            
            $estadoPeriodo->save();
            
            DB::commit();
            
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            
            throw $e;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            
            return false;
        }
    }
    
}