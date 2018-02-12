@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                @include('Reportes::presentismos.por-agente.reporte.form')
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                @include('Reportes::presentismos.por-agente.reporte.resumen')
            </div>
            <div class="col-md-9">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reporte de asistencias</h3>
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
                eventSources: [

                    // your event source
                    {
                        url: '{{route('reportesPresentismoIndividualPresentismosFecha')}}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: 'POST',
                        data: {
                            agente: '{{$agente->id}}',
                        },
                        error: function () {
                            alert('No se pudieron consultar los datos del presentismo');
                        },
                        success: function (data) {

                            $('#resumen').children('li').remove();

                            if (data.length === 0) {
                                $('#resumen').append('<li class="list-group-item"><b>No se encontraron licencias</b></li>');
                            } else {
                                var resumen = [];
                                var codigo = '';
                                for (var i = 0; i < data.length; i++) {
                                    codigo = data[i].tipo_presentismo.id;
                                    if (resumen[codigo] === undefined) {
                                        resumen[codigo] = {
                                            count: 1,
                                            codigo: data[i].tipo_presentismo.codigo,
                                            letra: data[i].tipo_presentismo.color_letra,
                                            background: data[i].tipo_presentismo.color,
                                        };
                                    } else {
                                        resumen[codigo].count++;

                                    }
                                }
                                $.each(resumen, function (index, item) {
                                    if (item !== undefined) {

                                        var li = '';
                                        li = '<li class="list-group-item"><span class="label" style="background: ' +
                                            item.background +
                                            '">' +
                                            item.codigo +
                                            '</span><a class="pull-right"><span class="description-text">' +
                                            item.count +
                                            '</span></a></li>';
                                        $('#resumen').append(li);
                                    }

                                });
                            }
                        }
                    }
                ],
                eventDataTransform: function (p) {
                    return {
                        title: p.tipo_presentismo.codigo + ' (' + ((p.injustificado === true) ? 'Injustificado' : 'Justificado') + ')',
                        start: moment(p.fecha, 'Y-MM-DD').format('Y-MM-DD'),
                        color: p.tipo_presentismo.color,
                        textColor: p.tipo_presentismo.color_letra,
                    };


                }

            })

        });


    </script>
@append