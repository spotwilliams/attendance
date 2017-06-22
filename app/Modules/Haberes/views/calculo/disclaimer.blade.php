@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Cierre de periodo</h3>
            </div>
            {!! Form::open(['route' => 'haberesConfirmarLote', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}
            {!! Form::hidden('base', $base->id) !!}
            {!! Form::hidden('periodo', $periodo->id) !!}
            {!! Form::hidden('turno', $turno->id) !!}
            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 4</span>
                            <span class="progress-number"><b>4</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-offset-3 col-md-6">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Aviso: Est&aacute; a punto de cerrar un periodo.</h4>
                        Esto significa que s&oacute;lo alguien con los <span class="">privilegios suficientes</span>
                        puede modificar los <span class="">presentismo</span> correspondientes a la
                        <span class="">base</span>,
                        <span class="">turno</span> y <span
                                class="">periodos</span> listados.

                    </div>
                    <div class="">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box bg-olive">
                            <span class="info-box-icon"><i class="fa fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Base</span>
                                <span class="info-box-number">{{$base->nombre}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
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
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box bg-olive">
                            <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Turno</span>
                                <span class="info-box-number">{{$turno->codigo}} ({{$turno->descripcion}})</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <a class="btn btn-default" href="{{URL::previous()}}">Volver</a>

                {!! Form::submit('Finalizar', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('select').attr('data-live-search', true).selectpicker({});
        })
    </script>
@append


