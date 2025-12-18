<?php

namespace Database\Seeders\Releases\R201803_1_nuevos_reques;

use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\ContratoHistorico;
use Cat\Models\EstadoContrato;
use Cat\Models\Gerencia;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Modules\Security\Models\Permission;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class FixFechaCierrePlantas extends Seeder
{
    
    public function run()
    {
        $this->fixFechaPlantas();
    }
    
    public function updateGerenciaMalEscrita()
    {
        Gerencia::where('id', '=', 1)
            ->update([
                'nombre' => 'Subgerencia Operativa Base Zona Centro',
            ]);
    }
    
    
    public function fixFechaPlantas()
    {
        $plantasId = TipoContrato::where('codigo', '=', TipoContrato::TIPO_SITUACION_REVISTA)
            ->get()
            ->pluck('id');
        
        $activosId = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)
            ->get()
            ->pluck('id');
        
        Contrato::whereIn('id_tipo_contrato', $plantasId)
            ->whereIn('id_estado_contrato', $activosId)
            ->whereDate('fecha_fin', '<>', '2600-12-31')
            ->update([
                'fecha_fin' => '2600-12-31',
            ]);
        
        ContratoHistorico::whereIn('id_tipo_contrato', $plantasId)
            ->whereIn('id_estado_contrato', $activosId)
            ->whereDate('fecha_fin', '<>', '2600-12-31')
            ->update([
                'fecha_fin' => '2600-12-31',
            ]);
        
        $locacionesId = TipoContrato::where('codigo', '=', TipoContrato::TIPO_LOCACION)
            ->get()
            ->pluck('id');
        
        
        Contrato::whereIn('id_tipo_contrato', $locacionesId)
            ->whereNull('fecha_estado_desde')
            ->whereNull('fecha_estado_hasta')
            ->update([
                'fecha_ingreso' => '2018-01-01',
                'fecha_fin'     => '2018-12-31',
            ]);
    
        ContratoHistorico::whereIn('id_tipo_contrato', $locacionesId)
            ->whereNull('fecha_estado_desde')
            ->whereNull('fecha_estado_hasta')
            ->update([
                'fecha_ingreso' => '2018-01-01',
                'fecha_fin'     => '2018-12-31',
            ]);
    }
    
}
