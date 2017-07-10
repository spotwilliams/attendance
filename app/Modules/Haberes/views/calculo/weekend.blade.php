<?php
use Cat\Helpers\Calculation;
$authDays = [];
if (Gate::allows('see-all-day')) {
    $authDays = [
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun',
    ];
}
/** @var \Cat\Models\Periodo $periodo */

$finesSemana      = Calculation::getWeekends(
    new DateTime($periodo->fecha_comienzo),
    new DateTime($periodo->fecha_fin),
    $authDays
);
$agentesCompletos = Calculation::addFaltasNoRegistradas($agentes->getCollection(), $finesSemana);


?>
@foreach($agentes as $a)
    <tr>
        <td class="details-control">
            @if($a->presentismos->isEmpty())
                <a class="btn btn-default details-control"><i class="fa fa-plus-circle"></i></a>
            @else
                <a class="btn btn-success details-control"><i class="fa fa-plus-circle"></i></a>
            @endif
        </td>

        <td>{{$a->apellido}}, {{$a->nombre}}</td>
        {{--<td>{{$a->dni}}</td>--}}
        <td>{{$a->cuit}}</td>
    </tr>
    <tr class="hidden">
        <input type="hidden" data-presentismos="{{$a->presentismos}}">
        <td colspan="10">
            @if($a->presentismos->isEmpty())
                <p class="help-block">No se registraron faltas injustificadas en el periodo.</p>
            @else
                <div class="row">
                    @foreach($a->presentismos->sortBy('fecha')->all() as $p)
                        @if($p->injustificado !== false)
                            <div class="col-xs-2">
                                <label>{{(new DateTime($p->fecha))->format('d/m')}}
                                    (@lang('day.'. (new DateTime($p->fecha))->format('D')))</label>
                                <input type="hidden" data-agente="{{json_encode($a->getAttributes())}}">
                                {!! \Cat\Helpers\HtmlCustoms::getSelectForTipoPresentismo($p, $a->contrato->tipoContrato) !!}

                            </div>
                        @endif
                    @endforeach
                </div>

            @endif


        </td>
    </tr>

@endforeach