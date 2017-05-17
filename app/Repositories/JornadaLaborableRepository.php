<?php

namespace Cat\Repositories;

use Cat\Models\JornadaLaborable;
use Cat\Models\Periodo;
use InfyOm\Generator\Common\BaseRepository;

class JornadaLaborableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable
        = [
            'fecha',
            'id_periodo',
        ];
    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return JornadaLaborable::class;
    }
    
    /**
     * @param \DateTime $fecha
     * @param Periodo|null $periodo
     * @return static
     */
    public static function getOrCreate(\DateTime $fecha, Periodo $periodo = null)
    {
        $fechaLaborable = JornadaLaborable::where('fecha', '=', $fecha->format('Y-m-d'))->first();
        
        if ($fechaLaborable === null) {
            if ($periodo === null) {
                $periodo = PeriodoRepository::getOrCreatePeriodoActivo($fecha);
            }
            
            $fechaLaborable = (new JornadaLaborable())
                ->save([
                    'fecha'      => $fecha->format('Y-m-d'),
                    'id_periodo' => $periodo->id,
                ]);
        }
        
        return $fechaLaborable;
        
    }
}
