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
                <h3 class="box-title">Notificar facturas de <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h3>
            </div>

            <div class="box-body">

                <div class="col-md-10 col-md-offset-1">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 3 - Confirmar montos y modo de env&iacute;o</span>
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
                    <input type="hidden" name="periodo" value="{{$periodo->id}}">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-default atras"><i
                                    class="fa fa-backward"></i>&nbsp;Atr&aacute;s
                        </button>
                        <a class="btn btn-default ninguno">Ninguno</a>
                        <a class="btn btn-default todos">Todos</a>
                        <button type="submit" class="btn btn-primary libre">Env&iacute;o libre</button>
                        <button type="submit" class="btn btn-primary regular">Env&iacute;o regular</button>
                    </div>
                </div>
            </div>

            <div class="box-body">

                <div class="col-md-12">

                    @include('Haberes::notificacion.parts.table-haberes')
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('button.atras, button.registrar').on('click', function (event) {
                event.preventDefault();
                var $form = $('form');
                if ($(this).hasClass('atras')) {
                    $form.prop('action', '{{route('notificacionIndex')}}')
                }
                if ($(this).hasClass('libre')) {
                    $form.prop('action', '{{route('notificacionIndex')}}')
                }
                if ($(this).hasClass('regular')) {
                    $form.prop('action', '{{route('notificacionIndex')}}')
                }
                $form.submit();
            });

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

