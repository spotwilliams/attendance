<?php

namespace Cat\Modules\Agentes\Services\Registro\Store;


use Cat\Models\Agente;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\Estudio;
use Cat\Models\JornadaLaborable;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Agentes\Services\Registro\CheckEstudiosAndDomicilio;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Personales extends Service
{
    use CheckEstudiosAndDomicilio;
    /** @var Agente */
    protected $agente;
    
    /** @var array */
    protected $domicilios;
    
    /** @var array */
    protected $estudios;
    
    
    public function __construct(Agente $agente, $domicilios = [], $estudios = [])
    {
        $this->agente     = $agente;
        $this->domicilios = $domicilios;
        $this->estudios   = $estudios;
    }
    
    public function execute()
    {
        try {
            
            DB::beginTransaction();
            $this->agente->save();
            
            if (isset($this->domicilios['calle'])) {
                
                for ($i = 0; $i < count($this->domicilios['calle']); $i++) {
                    if ($this->hasSomeUsefullData($this->domicilios, $i, ['constituido'])) {
                        Domicilio::create([
                            'calle'        => $this->domicilios['calle'][$i],
                            'libre'        => $this->domicilios['libre'][$i],
                            'numero'       => $this->domicilios['numero'][$i],
                            'departamento' => $this->domicilios['departamento'][$i],
                            'piso'         => $this->domicilios['piso'][$i],
                            'barrio'       => $this->domicilios['barrio'][$i],
                            'provincia'    => $this->domicilios['provincia'][$i],
                            'constituido'  => $this->domicilios['constituido'][$i],
                            'id_agente'    => $this->agente->id,
                        ]);
                    }
                }
            }
            if (isset($this->estudios['carrera'])) {
                for ($i = 0; $i < count($this->estudios['carrera']); $i++) {
                    if ($this->hasSomeUsefullData($this->estudios, $i, ['estado', 'nivelestudio'])) {
                        
                        Estudio::create([
                            'carrera'     => $this->estudios['carrera'][$i],
                            'institucion' => $this->estudios['institucion'][$i],
                            'estado'      => $this->estudios['estado'][$i],
                            'nivel'       => $this->estudios['nivelestudio'][$i],
                            'id_agente'   => $this->agente->id,
                        ]);
                    }
                }
            }
            
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}