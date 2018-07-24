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

            <div class="box-header text-center">
                <h4 class="box-title"><span class="label label-success">Notificaci&oacute;n de facturas</span> para
                    <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h4>
            </div>
            <div class="box-body text-center">
                <div class="col-md-12">
                    @include('Haberes::notificacion.parts.disclaimer-libre')
                </div>

            </div>
        </div>
        <div class="box">

            {{Form::open(['class' => 'form-horizontal'])}}
            <div class="box-header with-border">
                <h3 class="box-title">
                    Se enviar&aacute; mail notificando a <span
                            class="label label-info">@if(isset($agentes)){{$agentes->count()}}@else{{0}}@endif</span>
                    agentes</h3>
                <div class="box-tools pull-right">
                    <input type="hidden" name="periodo" value="{{$periodo->id}}">

                    <div class="btn-group">
                        <button type="submit" class="btn btn-default atras">
                            <i class="fa fa-refresh"></i>&nbsp;<span class="hidden-xs">Volver a buscar</span>
                        </button>
                        <button type="submit" class="btn btn-primary enviar">
                            <i class="fa fa-send"></i>&nbsp;<span class="hidden-xs">Enviar notificaci&oacute;n</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">

                        <div class="callout callout-warning">

                            <p>Los siguientes datos se incluir&aacute;n en el mail de notificaci&oacute;n,
                                por favor complete los datos faltantes</p>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Señor/es</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="GCBA" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Direcci&oacute;n</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Av. Belgrano 840" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Localidad</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Av. Belgrano 840" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">IVA</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Excento" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">COndiciones de venta</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Contado" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha de factura</label>

                            <div class="col-sm-8">
                                <input class="form-control fecha" name="fecha_factura">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha de pago</label>

                            <div class="col-sm-8">
                                <input class="form-control fecha" name="fecha_pago">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group @if($errors->has('mensaje')) has-error @endif">
                            <label class="col-sm-4 control-label">Mensaje</label>

                            <div class="col-sm-8">
                                <textarea class="form-control" name="mensaje" maxlength="400"
                                          placeholder="Escriba un mensaje de hasta 400 caracteres">{{old('mensaje')}}</textarea>
                                @if($errors->has('mensaje'))
                                    <label>{{$errors->first('mensaje')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group @if($errors->has('monto')) has-error @endif">
                            <label class="col-sm-4 control-label">Monto</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="monto" placeholder="$ 0.0"
                                       value="{{old('monto')}}">
                                @if($errors->has('monto'))
                                    <label>{{$errors->first('monto')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @include('Haberes::notificacion.parts.table-resumen')
                    </div>
                </div>

            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.fecha').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2018,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: moment()
            });
            $('button.atras, button.enviar').on('click', function (event) {
                event.preventDefault();
                var $form = $('form');
                if ($(this).hasClass('atras')) {
                    $form.prop('action', '{{route('notificacionSearch')}}')
                }
                if ($(this).hasClass('enviar')) {
                    $form.prop('action', '{{route('enviarNotificacionLibre')}}')
                }
                $form.submit();
            });
        })
    </script>
@append

