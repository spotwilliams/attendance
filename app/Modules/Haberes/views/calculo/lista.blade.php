<?php
use Cat\Models\TipoPresentismo;
use Cat\Helpers\HtmlCustoms;

/** @var \DateTime $fecha */
/** @var \Cat\Models\Periodo $periodo */
$fecha = new DateTime($periodo->fecha_comienzo);
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
            </div>

            <div class="box-body">

                <table class="table table-hover" id="haberes-table">
                    <thead>
                    <th>Detalle</th>
                    <th>Id Agente</th>
                    <th>Agente</th>
                    <th>CUIT</th>
                    <th>Monto</th>
                    {{--                    @foreach($fechasToShow as $fecha) --}}
                    {{-- <th data-cat="{{$fecha['data']}}">{{$fecha['show']}}</th> --}}
                    {{-- @endforeach --}}
                    </thead>
                    <tbody>
                    @foreach($agentes as $a)
                        <tr>
                            <td class="details-control">
                                <a class="btn btn-success"><i class="fa fa-plus-circle"></i></a>
                            </td>
                            <td>{{$a->id}}</td>
                            <td>{{$a->apellido}}, {{$a->nombre}}</td>
                            <td>{{$a->cuit}}</td>
                            <td>hola</td>

                        </tr>
                        <tr class="hidden">
                            <td colspan="5">
                                <p class="lead">Resumen</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @for($i = 0; $i < count($fechasToShow) ;$i++)
                                            <tr>
                                                <td>{{$fechasToShow[$i]['show']}}:</td>
                                                <td><?php

                                                    $p = (isset($a->presentismos[$i]) ? $a->presentismos[$i] : null);
                                                    echo HtmlCustoms::getProperHtmlForTipoPresentismo($p)
                                                    ?></td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
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
                    $(nextTr).removeClass('hidden');

                    $(button).addClass('btn-danger');
                    $(button).removeClass('btn-success');

                    $(icon).addClass('fa-minus-circle');
                    $(icon).removeClass('fa-plus-circle');

                }
            });

        });

    </script>
@append