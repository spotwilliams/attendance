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
                <h3 class="box-title">Registro facturas para <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h3>
            </div>

            <div class="box-body">

                <div class="col-md-10 col-md-offset-1">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 4 - Resumen</span>
                            <span class="progress-number"><b>4</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>

        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">
                    Se regist&oacute; factura para <span
                            class="label label-info">@if(isset($agentes)){{$agentes->count()}}@else{{0}}@endif</span>
                    agentes</h3>
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <a class="btn btn-default ninguno" href="{{route('haberesIndex')}}"><i class="fa fa-undo"></i>&nbsp;Volver</a>
                        <input type="submit" value="Siguiente" class="btn btn-primary">
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="col-md-12">
                    @include('Haberes::calculo.parts.table-resumen')
                </div>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
        })
    </script>
@append

