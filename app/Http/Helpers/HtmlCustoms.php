<?php

namespace Cat\Helpers;

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
            'id'           => '',
            'id_agente'    => '',
            'calle'        => '',
            'numero'       => '',
            'departamento' => '',
            'piso'         => '',
            'barrio'       => '',
            'provincia'    => '',
            'constituido'  => true,
            'libre'        => '',
            'created_at'   => '',
            'updated_at'   => '',
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

//        dd($return);
        
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
                'calle'        => $input['calle'][$i],
                'libre'        => $input['libre'][$i],
                'numero'       => $input['numero'][$i],
                'departamento' => $input['departamento'][$i],
                'piso'         => $input['piso'][$i],
                'barrio'       => $input['barrio'][$i],
                'provincia'    => $input['provincia'][$i],
                'constituido'  => $input['constituido'][$i],
                'id'           => $input['id'][$i],
            
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
        TipoContrato $tipoContrato,
        $selector = 'selectpicker'
    ) {
        /** @var array $tiposPresentismos */
        
        /** @var Collection $tiposPresentismos */
        $tiposPresentismos = TipoPresentismosRepository::getByTipoContrato($tipoContrato);
        
        $select = "<select class=\"$selector form-control\" data-live-search=\"true\" data-width=\"80px\" data-size=\"5\">";
        $option = "<option value=\"-1\">...</option>";
        
        $select .= $option;
        /** @var TipoPresentismo $tp */
        foreach ($tiposPresentismos as $tp) {
            // Option
            $seleccionado = ($tp->id === ($p == null ? -1 : $p->id_tipo_presentismo));
            $option       = "<option value=\"$tp->id\"";
            $option       .= $seleccionado ? ' selected' : '';
            $option       .= " data-content=\"<span class='label' style='color: $tp->color_letra; background-color: $tp->color;'>$tp->descripcion ($tp->codigo)</span>\"";
            $option       .= ">$tp->descripcion</option>";
            $select       .= $option;
        }
        $usuarioComentario = null;
        $fechaComentario   = null;
        if ($p !== null) {
            $btnDisabled       = '';
            $comentario        = $p->comentario;
            $usuarioComentario = $p->usuario;
            $fechaComentario   = (new \DateTime($p->fecha_comentario))->format('Y-m-d');
            $buttonJustice     = ($p->injustificado == true ?
                self::getButtonWithPopOver($p, true) :
                self::getButtonWithPopOver($p, false));
            $btnClass          = (!empty($p->comentario) ? 'bg-gray-active' : 'btn-default');
        } else {
            $comentario    = null;
            $btnDisabled   = 'disabled';
            $btnClass      = 'btn-default';
            $buttonJustice = self::getButtonWithPopOver($p, false, true);
        }
        
        if ($usuarioComentario == null) {
            $usuarioComentario = Auth::user()->email;
        }
        if ($fechaComentario == null) {
            $fechaComentario = (new \DateTime())->format('Y-m-d');
        }
        
        $select        .= '</select>';
        $buttonComment = "<button type='button' data-comentario='$comentario' data-usuario-comentario='$usuarioComentario' data-fecha-comentario='$fechaComentario' class='btn $btnClass dialog-comentary' $btnDisabled><i class='fa fa-comment-o'></i></button>";
        $buttonGroup   = "<div class=\"btn-group tools-presentismo\">$buttonComment$buttonJustice</div>";
        $select        .= $buttonGroup;
        
        $html = '<div class="form-group">';
        
        $html .= $select
            .= '</div>';
        
        return $html;
    }
    
    public static function getButtonWithPopOver(Presentismo $p = null, $injustificado = false, $disabled = false)
    {
        $title       = ($injustificado ? '<label class="label label-danger"> Injustificado</label>' : '<label class="label label-info"> Justificado</label>');
        $label       = ($injustificado ? 'Justificado' : 'Injustificado');
        $classToggle = ($injustificado ? 'label-info' : 'label-danger');
        $message     = "Click para marcar el presentismo como <label class=\"label $classToggle\">$label</label>";
        $icon        = '<i class=\'fa fa-check-square-o\'></i>';
        $toggles     = 'data-toggle=\'popover\' data-trigger=\'hover\'';
        
        $classButton = ($injustificado ? 'bg-gray-active' : 'btn-default');
        $data        = 'data-presentismo=\'' . (($p === null) ? '' : $p->toJson()) . '\'';
        $disabled    = ($disabled ? 'disabled' : ($p->id_tipo_presentismo === -1) ? 'disabled' : '');
        $button      = "<button type='button' class='btn $classButton' $data $toggles data-title='$title' data-content='$message' $disabled>$icon</button>";
        
        return $button;
    }
    
    
    public static function translateDay()
    {
    }
}