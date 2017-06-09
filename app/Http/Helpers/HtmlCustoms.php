<?php
namespace Cat\Helpers;

use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Illuminate\Support\Facades\Cache;

class HtmlCustoms
{
    public static function getDomiciliosArray(
        $input
        = [
            'session' => [],
            'model'   => [],
        ]
    ) {
        $return
            = [
            [
                'id'           => '',
                'id_agente'    => '',
                'calle'        => '',
                'numero'       => '',
                'departamento' => '',
                'piso'         => '',
                'barrio'       => '',
                'provincia'    => '',
                'constituido'  => '',
                'libre'        => '',
                'created_at'   => '',
                'updated_at'   => '',
            ],
        ];
        if (isset($input['session'])) {
            $return = self::getMultiDomicilioFromSession($input['session']['domicilio']);
        } elseif
        (isset($input['model'])) {
            $return = self::getMultiDomicilioFromModel($input['model']);
        }
        
        return $return;
    }
    
    public static function getEstudiosArray(
        $input
        = [
            'session' => [],
            'model'   => [],
        ]
    ) {
        $return
            = [
            [
                'carrera'     => '',
                'id'          => '',
                'institucion' => '',
                'estado'      => '',
                'nivel'       => '',
            ],
        ];
        if (isset($input['session'])) {
            $return = self::getMultiEstudiosFromSession($input['session']['estudio']);
        } elseif
        (isset($input['model'])) {
            $return = self::getMultiEstudiosFromModel($input['model']);
        }
        
        return $return;
    }
    
    private static function getMultiEstudiosFromSession($input)
    {
        $salida = [];
        
        for ($i = 0; $i < count($input['carrera']); $i++) {
            $salida[] = [
                'carrera'     => $input['carrera'][$i],
                'institucion' => $input['institucion'][$i],
                'estado'      => $input['estado'][$i],
                'nivel'       => $input['nivelestudio'][$i],
                'id'          => 'null',
            ];
        }
        
        return $salida;
        
    }
    
    private static function getMultiDomicilioFromSession($input)
    {
        $salida = [];
        for ($i = 0; $i < count($input['calle']); $i++) {
            $salida[] = [
                'calle'        => $input['calle'][$i],
                'libre'        => $input['libre'][$i],
                'numero'       => $input['numero'][$i],
                'departamento' => $input['departamento'][$i],
                'piso'         => $input['piso'][$i],
                'barrio'       => $input['barrio'][$i],
                'provincia'    => $input['provincia'][$i],
                'constituido'  => $input['constituido'][$i],
                'id'           => 'null',
            
            ];
        }
        
        return $salida;
    }
    
    
    private static function getMultiEstudiosFromModel(Agente $model)
    {
        return $model->estudio()->get()->toArray();
        
    }
    
    private static function getMultiDomicilioFromModel(Agente $model)
    {
        return $model->domicilios()->get()->toArray();
    }
    
    
    /**
     * @param Presentismo $p
     * @param $tiposPresentismosRefence
     * @return string
     */
    public static function getProperHtmlForTipoPresentismo(Presentismo $p = null)
    {
        /** @var array $tiposPresentismos AGREGAR CACHE!!! */
        $key               = 'tipo_presentismos_html_key_by';
        $tiposPresentismos = Cache::get($key);
        $color             = 'black';
        $label             = 'Injustificado';
        
        if ($tiposPresentismos == null) {
            $tiposPresentismos = TipoPresentismo::all()->keyBy('id')->toArray();
            Cache::put($key, $tiposPresentismos, 1440);
        }
        
        if ($p == null) {
            // Color injustificado
            $color = $tiposPresentismos[2]['color'];
        } else {
            if (isset($tiposPresentismos[$p->id_tipo_presentismo])) {
                $color = $tiposPresentismos[$p->id_tipo_presentismo]['color'];
                $label = $tiposPresentismos[$p->id_tipo_presentismo]['descripcion'];
            }
            
        }
        $html = "<span class=\"badge\" style=\"background-color: $color !important;\">$label</span>";
        
        return $html;
    }
}