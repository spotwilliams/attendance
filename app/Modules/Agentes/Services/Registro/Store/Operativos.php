<?php

namespace Cat\Modules\Agentes\Services\Registro\Store;


use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Contrato;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\EstadoContrato;
use Cat\Models\Estudio;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Horario;
use Cat\Models\JornadaLaborable;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Models\TurnoHistorico;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Operativos extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var  Gerencia */
    protected $gerencia;
    
    /** @var  Area */
    protected $area;
    
    /** @var  Cargo */
    protected $cargo;
    
    /** @var  Funcion */
    protected $funcion;
    
    /** @var  Base */
    protected $base;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  Horario */
    protected $horario;
    
    protected $funcion_especifica;
    
    public function __construct($input)
    {
        $this->agente             = Agente::findOrFail($input['agente']);
        $this->gerencia           = $this->getMockModelWhenNull(Gerencia::class, $input['id_gerencia']);
        $this->area               = $this->getMockModelWhenNull(Area::class, $input['id_area']);
        $this->cargo              = $this->getMockModelWhenNull(Cargo::class, $input['id_cargo']);
        $this->funcion            = Funcion::findOrFail($input['id_funcion']);
        $this->funcion_especifica = $input['funcion_especifica'];
        $this->base               = Base::findOrFail($input['id_base']);
        $this->turno              = Turno::findOrFail($input['id_turno']);
        $this->horario            = [
            'hora_entrada' => $input['hora_entrada'],
            'hora_salida'  => $input['hora_salida'],
            'eximido'      => ($input['eximido'] == 1 ? true : false),
            'rotativo'     => ($input['rotativo'] == 1 ? true : false),
        ];
    }
    
    public function execute()
    {
        
        try {
            DB::beginTransaction();
            
            $this->horario = Horario::create($this->horario);
            $operativo     = Operativo::create([
                'id_agente'          => $this->agente->id,
                'id_gerencia'        => $this->gerencia->id,
                'id_base'            => $this->base->id,
                'id_area'            => $this->area->id,
                'id_cargo'           => $this->cargo->id,
                'id_funcion'         => $this->funcion->id,
                'funcion_especifica' => $this->funcion_especifica,
                'id_turno'           => $this->turno->id,
                'id_horario'         => $this->horario->id,
            ]);
            
            
            TurnoHistorico::create([
                'id_operativo' => $operativo->id,
                'id_turno'     => $this->turno->id,
                'fecha_inicio' => Carbon::now()->format('Y-m-d'),
            ]);
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}