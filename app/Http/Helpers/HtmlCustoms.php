<?php

namespace Cat\Helpers;

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HtmlCustoms
{
    public static function getDomiciliosArray(
        
        $input
        = [
            'session' => [],
            'model'   => [],
        ]
    ) {
        $domicilioTemplate = [
            'id'            => '',
            'id_agente'     => '',
            'calle'         => '',
            'numero'        => '',
            'departamento'  => '',
            'piso'          => '',
            'barrio'        => '',
            'provincia'     => '',
            'constituido'   => true,
            'libre'         => '',
            'codigo_postal' => '',
            'created_at'    => '',
            'updated_at'    => '',
        ];
        
        $return                           = [];
        $return ['constituido']           = $domicilioTemplate;
        $return ['nominal']               = $domicilioTemplate;
        $return['nominal']['constituido'] = false;
        
        if (isset($input['session'])) {
            self::getMultiDomicilioFromSession($input['session']['domicilio'], $return);
        } elseif
        (isset($input['model'])) {
            self::getMultiDomicilioFromModel($input['model'], $return);
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
        $original = $return
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
        
        return empty($return) ? $original : $return;
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
                'id'          => $input['id'][$i],
            ];
        }
        
        return $salida;
        
    }
    
    private static function getMultiDomicilioFromSession($input, &$salida)
    {
        for ($i = 0; $i < count($input['calle']); $i++) {
            
            if ($input['constituido'][$i] == true) {
                $key = 'constituido';
            } else {
                $key = 'nominal';
            }
            $salida[$key] = [
                'calle'         => $input['calle'][$i],
                'libre'         => $input['libre'][$i],
                'numero'        => $input['numero'][$i],
                'departamento'  => $input['departamento'][$i],
                'piso'          => $input['piso'][$i],
                'barrio'        => $input['barrio'][$i],
                'provincia'     => $input['provincia'][$i],
                'codigo_postal' => $input['codigo_postal'][$i],
                'constituido'   => $input['constituido'][$i],
                'id'            => $input['id'][$i],
            
            ];
        }
        
        return $salida;
    }
    
    
    private static function getMultiEstudiosFromModel(Agente $model)
    {
        return $model->estudio()->get()->toArray();
        
    }
    
    private static function getMultiDomicilioFromModel(Agente $model, &$salida)
    {
        $input = $model->domicilios()->get()->toArray();
        for ($i = 0; $i < count($input); $i++) {
            
            if ($input[$i]['constituido'] == true) {
                $key = 'constituido';
            } else {
                $key = 'nominal';
            }
            $salida[$key] = $input[$i];
        }
    }
    
    
    /**
     * @param Presentismo|null $p
     * @param string $selector
     * @return string
     */
    public static function getSelectForTipoPresentismo(
        Presentismo $p = null,
        Agente $agente,
        $selector = 'selectpicker'
    ) {
        $select = self::getSelect($p, $agente, $selector);
        $tools  = self::getButtonsTools($p);
        
        $html = "<div class='form-group'>$select $tools</div>";
        
        return $html;
    }
    
    
    public static function getSelect(Presentismo $p = null, Agente $agente, $selector = 'selectpicker')
    {
        $date = ($p === null) ? null : new Carbon($p->fecha);
        /** @var Collection $tiposPresentismos */
        $tiposPresentismos = TipoPresentismosRepository::getByTipoContratoOnDate($agente, $date);
        
        $select = "<select class=\"$selector form-control\" data-live-search=\"true\" data-width=\"80px\" data-size=\"5\">";
        $option = "<option value=\"-1\">...</option>";
        
        $select .= $option;
        /** @var TipoPresentismo $tp */
        foreach ($tiposPresentismos as $tp) {
            // Option
            $seleccionado = ($tp->id === ($p == null ? -1 : $p->id_tipo_presentismo));
            $option       = "<option value=\"$tp->id\"";
            $option       .= ' data-tokens="' . $tp->codigo . '" ';
            $option       .= $seleccionado ? ' selected' : '';
            $option       .= " data-content=\"<span class='label' style='color: $tp->color_letra; background-color: $tp->color;'>$tp->descripcion ($tp->codigo)</span>\"";
            $option       .= ">$tp->descripcion</option>";
            $select       .= $option;
        }
        
        
        $select .= '</select>';
        
        return $select;
    }
    
    public static function getButtonsTools(Presentismo $p = null)
    {
        $buttonJustice = self::getButtonWithPopOver($p);
        $buttonComment = self::getCommentButton($p);
        $buttonGroup   = "<div class=\"btn-group tools-presentismo\">$buttonComment$buttonJustice</div>";
        
        return $buttonGroup;
    }
    
    public static function getCommentButton(Presentismo $p = null)
    {
        $tildeClass    = ($p && ($p->comentario == 'SI')) ? 'fa-comment text-yellow' : 'fa-comment-o';
        $idPresentismo = $p ? $p->id : -1;
        $btnDisabled   = ($p == null || ($p->id_tipo_presentismo == -1)) ? 'disabled' : '';
        
        
        $buttonComment = "<button type='button' data-id-presentismo='$idPresentismo' class='btn btn-default dialog-comentary' $btnDisabled><i class='fa $tildeClass'></i></button>";
        
        return $buttonComment;
    }
    
    public static function getButtonWithPopOver(Presentismo $p = null)
    {
        $injustificado = ($p && ($p->injustificado == true)) ? true : false;
        $disabled      = (($p != null) && ($p->id_tipo_presentismo != -1)) ? '' : 'disabled';
        $title         = ($injustificado ? '<label class="label label-danger"> Injustificado</label>' : '<label class="label label-info"> Justificado</label>');
        $label         = ($injustificado ? 'Justificado' : 'Injustificado');
        $classToggle   = ($injustificado ? 'label-info' : 'label-danger');
        $message       = "Click para marcar el presentismo como <label class=\"label $classToggle\">$label</label>";
        $toggles       = 'data-toggle=\'popover\' data-trigger=\'hover\'';
        
        if ($p) {
            $classButton = ($injustificado ? 'fa-check-square text-red' : 'fa-check-square text-green');
        } else {
            $classButton = 'fa-check-square-o';
        }
        $icon   = "<i class='fa $classButton'></i>";
        $data   = 'data-presentismo=\'' . (($p === null) ? '' : $p->toJson()) . '\'';
        $button = "<button type='button' class='btn btn-default' $data $toggles data-title='$title' data-content='$message' $disabled>$icon</button>";
        
        return $button;
    }
    
    
    public static function getSelectByTipoContrato(
        TipoContrato $tipoContrato,
        $multiple = false,
        $selector = 'selectpicker',
        $with = '150px'
    ) {
        
        /** @var Collection $tiposPresentismos */
        $tiposPresentismos = TipoPresentismosRepository::getByTipoContrato($tipoContrato);
        $multipleOpt       = (($multiple === true) ? 'name="tipos[]" multiple multiple data-actions-box="true" ' : ' name="tipo" ');
        $select            = "<select class=\"$selector form-control\" data-live-search=\"true\" data-width=\"$with\" data-size=\"5\" $multipleOpt >";
        
        $option = ($multiple) ? '' : "<option value=\"-1\">...</option>";
        
        $select .= $option;
        /** @var TipoPresentismo $tp */
        foreach ($tiposPresentismos as $tp) {
            // Option
            $option = "<option value=\"$tp->id\"";
            $option .= ' data-tokens="' . $tp->codigo . '" ';
            $option .= " data-content=\"<span class='label' style='color: $tp->color_letra; background-color: $tp->color;'>$tp->descripcion ($tp->codigo)</span>\"";
            $option .= ">$tp->descripcion</option>";
            $select .= $option;
        }
        
        
        return $select .= '</select>';
    }
}