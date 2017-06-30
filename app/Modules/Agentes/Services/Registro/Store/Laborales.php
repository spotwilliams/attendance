<?php

namespace Cat\Modules\Agentes\Services\Registro\Store;


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
    
    /** @var  string Casting before save */
    protected $monto;
    
    /** @var  EstadoContrato */
    protected $estado;
    
    /** @var  TipoContrato */
    protected $tipo;
    
    /** @var  string */
    protected $id_sial;
    
    /** @var  \DateTime */
    protected $fecha_baja;
    
    /** @var  string */
    protected $comentario_baja;
    
    /** @var  \DateTime */
    protected $tipo_inscripcion;
    
    /** @var  \DateTime */
    protected $fecha_ingreso_gobierno;
    
    public function __construct(Agente $agente, $input)
    {
        
        $this->agente  = $agente;
        $this->id_sial = $input['id_sial'];
        $this->ficha   = $input['ficha'];
        $this->monto   = $input['monto'];
        $this->fecha   = new \DateTime($input['fecha_ingreso']);
        $this->estado  = EstadoContrato::findOrFail($input['id_estado_contrato']);
        $this->tipo    = TipoContrato::findOrFail($input['id_tipo_contrato']);
        
        $this->fecha_ingreso_gobierno = new \DateTime($input['fecha_ingreso_gobierno']);
        $this->tipo_inscripcion       = $input['tipo_inscripcion'];
        $this->fecha_baja             = ($this->estado->esActivo() ? null : new \DateTime($input['fecha_baja']));
        $this->comentario_baja        = ($this->estado->esActivo() ? null : $input['comentario_baja']);
    }
    
    public function execute()
    {
        
        try {
            
            DB::beginTransaction();
            $this->agente->save();
            
            /** @var Contrato $contrato */
            $contrato = Contrato::firstOrCreate([
                'id_tipo_contrato'   => $this->tipo->id,
                'id_estado_contrato' => $this->estado->id,
                'id_agente'          => $this->agente->id,
            ]);
            
            $contrato->update([
                'fecha_ingreso'          => $this->fecha->format('Y-m-d'),
                'id_sial'                => $this->id_sial,
                'ficha'                  => $this->ficha,
                'monto'                  => floatval($this->monto),
                'fecha_baja'             => $this->fecha_baja,
                'comentario_baja'        => $this->comentario_baja,
                'tipo_inscripcion'       => $this->tipo_inscripcion,
                'fecha_ingreso_gobierno' => $this->fecha_ingreso_gobierno,
            
            ]);
            
            DB::commit();
            
            return $this->agente;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}