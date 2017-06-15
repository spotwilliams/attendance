<?php

namespace Cat\Helpers;

use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Illuminate\Support\Collection;

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
    public static function getSelectForTipoPresentismo(Presentismo $p = null, $selector = 'selectpicker')
    {
        /** @var array $tiposPresentismos AGREGAR CACHE!!! */
        
        /** @var Collection $tiposPresentismos */
        $tiposPresentismos = Cache::get(
            'tipo_presentismos_html_key_by',
            function () {
                return TipoPresentismo::all();
            });
        
        $select = "<select class=\"$selector form-control\" data-live-search=\"true\" data-width=\"80px\" data-size=\"5\">";
        $option = "<option value=\"-1\">...</option>";
        
        $select .= $option;
        /** @var TipoPresentismo $tp */
        foreach ($tiposPresentismos as $tp) {
            // Option
            $seleccionado = ($tp->id === ($p == null ? -1 : $p->id_tipo_presentismo));
            $option       = "<option value=\"$tp->id\"";
            $option       .= $seleccionado ? ' selected' : '';
            $option       .= " data-content=\"<span class='label' style='background-color: $tp->color;'>$tp->descripcion</span>\"";
            $option       .= ">$tp->descripcion</option>";
            $select       .= $option;
        }
        $btnDisabled = ($p !== null ? '' : ' disabled');
        $comentario = ($p !== null ? $p->comentario : null);
        
        $btnClass    = (($p !== null) && !empty($p->comentario) ? 'btn-success' : 'btn-default');
        $select      .= '</select>';
        $button      = "<button type='button' data-comentario='$comentario' class='btn $btnClass dialog-comentary' $btnDisabled><i class='fa fa-comment-o'></i></button>";
        $select      .= $button;
        
        $html = "<div class=\"form-group\">";
        
        $html .= $select
            .= "</div>";
        
        /*
         * 'data-content="'
                        + '<span class=\'label\' style=\'background-color: ' + tipoPresentismos[i].color + ';\'>' + tipoPresentismos[i].descripcion + '</span>">'
         */
        
        return $html;
    }
}