<?php

namespace Cat\Database\Seeds\Releases\R201803_1_nuevos_reques;

use Cat\Models\Agente;
use Cat\Models\Gerencia;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Modules\Security\Models\Permission;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class NuevosRequerimientos extends Seeder
{
    
    public function run()
    {
        $this->permisos();
        $this->updatePresentismos();
    }
    
    public function updateGerenciaMalEscrita()
    {
        Gerencia::where('id', '=', 1)
            ->update([
                'nombre' => 'Subgerencia Operativa Base Zona Centro',
            ]);
    }
    
    public function permisos()
    {
        $ps = [
            // Eliminacion de configuraciones
            //            [
            //                'id'          => 21,
            //                'name'        => 'Eliminar area',
            //                'comentarios' => '',
            //            ],
            //            [
            //                'id'          => 22,
            //                'name'        => 'Eliminar base',
            //                'comentarios' => '',
            //            ],
            //            [
            //                'id'          => 23,
            //                'name'        => 'Eliminar turno',
            //                'comentarios' => '',
            //            ],
            
            [
                'id'          => 24,
                'name'        => 'Vista previa liquidacion',
                'comentarios' => '',
            ],
            [
                'id'          => 25,
                'name'        => 'Modificar contratos',
                'comentarios' => '',
            ],
        ];
        
        
        foreach ($ps as $p) {
            try {
                Permission::create($p);
            } catch (\Exception $e) {
            }
        }
    }
    
    public function updatePresentismos()
    {
        /** @var Collection $presentismos */
        $presentismos = \Cat\Models\Presentismo::select(['id_agente'])
            ->distinct()
            ->get();
        
        $agentesEloq = Agente::whereIn('id', $presentismos->pluck('id_agente'))
            ->with([
                'contrato' => function ($with) {
                    $with
                        ->with('estadoContrato')
                        ->with('tipoContrato');
                },
            ])
            ->with('operativo.turno');;
        /** @var ProgressBar $bar */
        $bar = $this->command->getOutput()->createProgressBar($agentesEloq->count());
        
        
        foreach ($agentesEloq->get() as $agente) {
            
            try {
                
                \Cat\Models\Presentismo::where('id_agente', '=', $agente->id)
                    ->update([
                        'id_estado_contrato' => $agente->contrato->estadoContrato->id,
                        'id_tipo_contrato'   => $agente->contrato->tipoContrato->id,
                        'id_turno'           => $agente->operativo->turno->id,
                    ]);
                
                $bar->advance();
                
            } catch (\Exception $e) {
                $message = "{$agente->cuit},";
                $this->command->warn($message);
            }
        }
        
    }
}
