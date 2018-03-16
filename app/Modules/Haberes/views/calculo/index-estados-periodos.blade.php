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
            {!! Form::open(['route' => 'haberesListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST']) !!}

            <div class="box-body">

                <div class="col-md-offset-2 col-md-8">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 1</span>
                            <span class="progress-number"><b>1</b>/3</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">Aviso</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span>S&oacute;lo Se listan las Bases y Turnos con agentes con contratos de Locaci&oacute;n de Servicios y Obra
                            </span>

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <select class="form-control" name="periodo" title="Seleccione un periodo...">
                        @foreach($estadosPeriodos->groupBy('id_periodo') as $idPeriodo => $estados)
                            <optgroup
                                    label="Periodo desde {{(new DateTime($estados->first()->periodo->fecha_comienzo))->format('d/M/Y')}} hasta {{(new DateTime($estados->first()->periodo->fecha_fin))->format('d/M/Y')}}">
                                @foreach($estados as $e)
                                    <option value="{{$e->id}}">{{$e->base->nombre}} - {{$e->turno->codigo}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
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


