@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-3">
                @include('Reportes::presentismos.por-agente.reporte.resumen')
            </div>
            <div class="col-md-9">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reporte de asistencias</h3>
                        <div class="box-tools pull-right">
                            {!! Form::open(['route' => 'reportesPresentismoIndividualExport']) !!}
                            <button type="submit" class="btn btn-default">Exportar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12 col-xs-12 table-responsive">

                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
<?php
$presentismos = $agente->presentismos->keyBy('fecha');
?>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            // page is now ready, initialize the calendar...

            $('#calendar').fullCalendar({
                fixedWeekCount: false,
                height: 500,
                buttonText: {
                    today: 'hoy',
                    month: 'mes',
                    week: 'semana',
                    day: 'dia',
                    list: 'lista',
                },
                defaultDate: '{{(new DateTime(\Carbon\Carbon::today()->firstOfMonth()))->format('Y-m-d')}}',
                events: [
                        @foreach($presentismos as $p)
                    {
                        title: '{!! $p->tipoPresentismo->codigo !!}',
                        start: '{!! (new DateTime($p->fecha))->format('Y-m-d') !!}',
                        color: '{{$p->tipoPresentismo->color}}',
                        textColor: '{{$p->tipoPresentismo->color_letra}}',
                    },
                    @endforeach
                ],

            })

        });


    </script>
@append