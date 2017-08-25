<?php

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
            </div>

            <div class="box-body">
                <div class="form-group col-sm-10 col-sm-offset-1">
                    <div class="progress-group ">
                        <span class="progress-text">Paso 4</span>
                        <span class="progress-number"><b>4</b>/4</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box bg-olive">
                            <span class="info-box-icon"><i class="fa fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Base</span>
                                <span class="info-box-number">{{$base->nombre}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box bg-olive">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Periodo</span>
                                <span class="info-box-number">{{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}}
                                    hasta {{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box bg-olive">
                            <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Turno</span>
                                <span class="info-box-number">{{$turno->codigo}}
                                    {{--({{$turno->descripcion}})--}}
                                </span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>

                <tr>
                    <td colspan="10">
                        <div class="col-md-4">
                            <a class="btn btn-primary" href="{{route('haberesSelectBase')}}">Volver</a>
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['route' => 'haberesNotificar']) !!}
                            {!! Form::hidden('periodo', $periodo->id) !!}
                            {!! Form::hidden('base', $base->id) !!}
                            {!! Form::hidden('turno', $turno->id) !!}
                            <input type="submit"
                                   class="btn btn-primary"
                                   value='Notificar via mail'/>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::open(['route' => 'haberesReporte', 'method' => 'POST']) !!}
                            {!! Form::hidden('periodo', $periodo->id) !!}
                            {!! Form::hidden('turno', $turno->id) !!}
                            {!! Form::hidden('base', $base->id) !!}
                            <button type="submit" class="btn btn-success pull-right">
                                <i class="fa fa-download"></i> Obtener reporte
                            </button>
                            {!! Form::close() !!}
                        </div>


                    </td>
                </tr>
            </div>

        </div>
    </div>

@endsection
