<?php
use Cat\Models\TipoPresentismo;
use Cat\Helpers\HtmlCustoms;
use Cat\Repositories\TipoPresentismosRepository;

/** @var \DateTime $fecha */
/** @var \Cat\Models\Periodo $periodo */
$fecha      = new DateTime($periodo->fecha_comienzo);
$fechaToday = (new DateTime($periodo->fecha_fin));

$fechasToShow = [];

while ($fecha < $fechaToday) {
    $fechasToShow[] = ['data' => $fecha->format('Y-m-d'), 'show' => $fecha->format('d/m')];
    $fecha->modify('+1day');
}

?>

@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">C&aacute;lculo de haberes</h3>
                <div class="box-tools pull-right">
                    @if(!$agentes->isEmpty())
                        {!! Form::open(['route' => 'haberesConfirmarLote']) !!}
                        @foreach($agentes->getCollection()->keyBy('id')->keys()->all() as $age)
                            {!! Form::hidden('agentes[]', $age) !!}
                        @endforeach
                        {!! Form::hidden('periodo', $periodo->id) !!}
                        {!! Form::hidden('base', $base->id) !!}
                        {!! Form::hidden('page', $agentes->currentPage())!!}
                        <input type="submit" class="btn btn-primary" value='Confimar esta hoja'/>
                        {!! Form::close() !!}
                    @endif
                </div>

            </div>

            <div class="box-body">
                <div class="form-group">
                    <div class="progress-group col-sm-8 col-sm-offset-2">
                        <span class="progress-text">Paso 3</span>
                        <span class="progress-number"><b>3</b>/3</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <table class="table table-hover" id="haberes-table">
                    <thead>
                    <th>Detalles</th>
                    <th>Agente</th>
                    <th>DNI</th>
                    <th>CUIT</th>
                    <th>Monto contrato</th>
                    <th>Monto a facturar</th>
                    <th>Confirmar</th>
                    </thead>
                    <tbody>
                    @if($agentes->isEmpty())
                        <tr>
                            <td colspan="10">
                                <p class="help-block">No se encontraron presentismos cargados para esta base.</p>
                            </td>
                        </tr>
                    @endif
                    @foreach($agentes as $a)
                        <tr>
                            <td class="details-control">
                                <a class="btn btn-success"><i class="fa fa-plus-circle"></i></a>
                            </td>

                            <td>{{$a->apellido}}, {{$a->nombre}}</td>
                            <td>{{$a->dni}}</td>
                            <td>{{$a->cuit}}</td>
                            <td>$ {{$a->contrato->monto}}</td>
                            <td>
                                @if(!$a->haberes->isEmpty())
                                    $ {{$a->haberes->first()->monto_facturado}}
                                @else
                                    $ {{money_format('%i', (new \Cat\Modules\Haberes\Services\Calculo\Calculador($a, $periodo))->execute())}}</td>
                            @endif
                            <td>
                                @if($a->haberes->isEmpty())
                                    {!! Form::open(['route' => 'haberesConfirmarSingle']) !!}
                                    {!! Form::hidden('agente', $a->id) !!}
                                    {!! Form::hidden('periodo', $periodo->id) !!}
                                    {!! Form::hidden('base', $base->id) !!}
                                    {!! Form::hidden('page', $agentes->currentPage()) !!}
                                    <input type="submit" class="btn btn-primary" value='Confimar'></input>
                                    {!! Form::close() !!}

                                @else
                                    <h4>
                                        <span class="label label-success"><i class="fa fa-check-circle-o">&nbsp;Confirmado</i></span>
                                    </h4>
                                @endif
                            </td>

                        </tr>
                        <tr class="hidden">
                            <input type="hidden" data-presentismos="{{$a->presentismos}}">
                            <td colspan="10">
                                <p class="lead">Resumen:</p>
                                <div class="table-responsive"></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">

                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var detailRows = [];

            $('table tbody').on('click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var nextTr = $(tr).next('tr');
                var button = $(this).children('a');
                var icon = $(this).children('a').children('i');
                // Si es visible lo tengo que esconder
                if ($(nextTr).is(':visible')) {

                    $(nextTr).addClass('hidden');

                    $(button).addClass('btn-success');
                    $(button).removeClass('btn-danger');

                    $(icon).addClass('fa-plus-circle');
                    $(icon).removeClass('fa-minus-circle');

                } else {
                    var cell = $(nextTr).children('td');
                    var data = $(nextTr).children('input').data('presentismos');
                    $(nextTr).removeClass('hidden');

                    $(button).addClass('btn-danger');
                    $(button).removeClass('btn-success');

                    $(icon).addClass('fa-minus-circle');
                    $(icon).removeClass('fa-plus-circle');
                    renderDetails(data, cell);

                }
            });

            /**
             *
             * @param data Datos
             * @param container Celda
             */
            function renderDetails(data, container) {
                var tiposPresentismo = {!! \Cat\Repositories\TipoPresentismosRepository::getAll()->toJson() !!};
                for (var i = 0; i < data.length; i++) {

                    for (var tpIxd = 0; tpIxd < tiposPresentismo.length; tpIxd++) {
                        if (tiposPresentismo[tpIxd].cant == undefined) {
                            tiposPresentismo[tpIxd].cant = 0;
                        }
                        if (tiposPresentismo[tpIxd].id == data[i].id_tipo_presentismo) {

                            tiposPresentismo[tpIxd].cant = tiposPresentismo[tpIxd].cant + 1;
                            break;
                        }
                    }
                }
                var div = $(container).children('div');
                if ($(div[0]).children('table').length) {
                    // En caso que ya exista, salimos
                    return;
                }
                var insidetable = $('<table>')
                    .addClass('table no-margin');

                for (var tp = 0; tp < tiposPresentismo.length; tp++) {
                    if (tiposPresentismo[tp].cant != undefined && tiposPresentismo[tp].cant != 0) {

                        var tr = $('<tr>');
                        var tdIzq = $('<td>');
                        var tdDer = $('<td>');
                        var contIzq = $('<span>')
                            .addClass('label')
                            .css('background', tiposPresentismo[tp].color)
                            .text(tiposPresentismo[tp].descripcion);
//
                        var contDer = $('<span>')
                            .text(tiposPresentismo[tp].cant);

                        $(tdIzq).append(contIzq);
                        $(tdDer).append(contDer);

                        $(tr).append(tdIzq);
                        $(tr).append(tdDer);


                        $(insidetable).append(tr);
                    }
                }
                $(div[0]).append(insidetable);
            }
        });

    </script>
@append