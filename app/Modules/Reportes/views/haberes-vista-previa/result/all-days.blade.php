<?php

use Cat\Helpers\Calculation;
use Illuminate\Support\Facades\Gate;

if (isset($periodo)) {

    /** @var \Cat\Models\Periodo $periodo */
    $turnosFinSemana = ['FSN', 'FSD', 'FSI'];
    if (in_array($turno->codigo, $turnosFinSemana)) {

        $diasSemana = Calculation::getWeekends(
            new DateTime($periodo->fecha_comienzo),
            new DateTime($periodo->fecha_fin)
        );
    } else {

        $diasSemana = Calculation::getWeekDays(
            new DateTime($periodo->fecha_comienzo),
            new DateTime($periodo->fecha_fin)
        );
    }
    $agentesCompletos = Calculation::addFaltasNoRegistradas($agentes->getCollection(), $diasSemana);
} else {
    $agentesCompletos = new \Illuminate\Support\Collection();
}

?>
@if(!$agentesCompletos->isEmpty())
    @foreach($agentesCompletos as $a)
        <tr>
            <td class="details-control">
                @if($a->presentismos->isEmpty())
                    <a class="btn btn-default details-control"><i class="fa fa-plus-circle"></i></a>
                @else
                    <a class="btn btn-success details-control"><i class="fa fa-plus-circle"></i></a>
                @endif
            </td>

            <td>{{$a->apellido}}, {{$a->nombre}}</td>
            <td>{{$a->cuit}}</td>
            <td><a href="{{route('agentesShow', ['id' => $a->id])}}" data-toggle="popover" title="Ver datos"
                   data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank"
                   class="label label-success"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        <tr class="hidden">
            {{--        <input type="hidden" data-presentismos="{{$a->presentismos}}">--}}
            <td colspan="10">
                @if($a->presentismos->isEmpty())
                    <p class="help-block col-md-12">No se registraron faltas injustificadas en el periodo.</p>
                @else
                    <div class="row">
                        @foreach($a->presentismos->sortBy('fecha')->all() as $p)
                            @if($p->injustificado !== false)
                                <div class="col-xs-2">
                                    <label>{{(new DateTime($p->fecha))->format('d/m')}}
                                        (@lang('day.'. (new DateTime($p->fecha))->format('D')))</label>
                                    <input type="hidden" data-agente="{{json_encode($a->getAttributes())}}">
                                    {!! \Cat\Helpers\HtmlCustoms::getSelectForTipoPresentismo($p, $a) !!}

                                </div>
                            @endif
                        @endforeach
                    </div>

                @endif


            </td>
        </tr>

    @endforeach
@else
    <tr>
        <th align="center" colspan="3"><span class="label label-info">No se encontraron agentes con contrato de locaci&oacute;n</span></th>
    </tr>
@endif
