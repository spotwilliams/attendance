<?php

namespace Cat\Modules\Agentes\Services\Registro\Update;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\EstadoContrato;
use Cat\Models\Estudio;
use Cat\Models\JornadaLaborable;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Laborales extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var  string */
    protected $ficha;
    
    /** @var  \DateTime */
    protected $fecha;
    
    /** @var  EstadoContrato */
    protected $estado;
    
    /** @var  TipoContrato */
    protected $tipo;
    
    protected $id_sial;
    
    
    public function __construct(Agente $agente, $input)
    {
        
        $this->agente  = $agente;
        $this->id_sial = $input['id_sial'];
        $this->ficha   = $input['ficha'];
        $this->fecha   = new \DateTime($input['fecha_ingreso']);
        $this->estado  = EstadoContrato::findOrFail($input['id_estado_contrato']);
        $this->tipo    = TipoContrato::findOrFail($input['id_tipo_contrato']);
    }
    
    public function execute()
    {
        
        try {
            
            DB::beginTransaction();
            $this->agente
                ->contrato()
                ->first()
                ->update([
                    'fecha_ingreso'      => $this->fecha->format('Y-m-d'),
                    'id_tipo_contrato'   => $this->tipo->id,
                    'id_estado_contrato' => $this->estado->id,
                    'id_agente'          => $this->agente->id,
                    'id_sial'            => $this->id_sial,
                    'ficha'              => $this->ficha,
                ]);
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}