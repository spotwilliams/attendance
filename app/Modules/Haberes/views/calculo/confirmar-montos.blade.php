@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <?php

        $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
        $mesFacturacion->addMonth(1);

        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
        ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Registar facturas para <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h3>
            </div>

            <div class="box-body">

                <div class="col-md-10 col-md-offset-1">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 3 - Confirmar montos</span>
                            <span class="progress-number"><b>3</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>

        <div class="box">
            {!! Form::open(['method' => 'POST', 'route' => 'haberesRegistrarFactura']) !!}
            <input type="hidden" name="periodo" value="{{$periodo->id}}">

            <div class="box-header with-border">
                <h3 class="box-title"><span
                            class="label label-info">@if(isset($agentes)){{$agentes->count()}}@else{{0}}@endif</span>
                    agentes encontrados</h3>
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <a class="btn btn-default ninguno">Ninguno</a>
                        <a class="btn btn-default todos">Todos</a>
                        <input type="submit" value="Registrar" class="btn btn-primary">
                    </div>
                </div>
            </div>

            <div class="box-body">

                <div class="col-md-12">

                    @include('Haberes::calculo.parts.table-haberes')
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {


            $('a.todos, a.ninguno').on('click', function () {
                if ($(this).hasClass('ninguno')) {
                    $('input[type="checkbox"].agente-option').prop('checked', false).change();
                } else {
                    $('input[type="checkbox"].agente-option').prop('checked', true).change();
                }
            });

            $('input[type="checkbox"].agente-option').change(function (event) {
                var rw = $(this).parents('tr');
                var text = $(rw).find('input[type="text"]').not(':hidden');

                if (this.checked) {
                    $(text).prop('disabled', false);
                } else {
                    $(text).prop('disabled', true);
                }
            });

            // Para activar el change si estaban precargardos
            // $('input[type="checkbox"].agente-option:checked').prop('checked', true).change();

        })
    </script>
@append

