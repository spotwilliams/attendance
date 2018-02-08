@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>


        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Error en el reporte</h3>
            </div>

            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 3</span>
                            <span class="progress-number"><b>3</b>/3</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-offset-3 col-md-6">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Aviso: No se puede obtener el reporte solicitado.</h4>
                        Se ha detectado que el reporte no se pudo generar de manera correcta.

                    </div>
                    @include('flash::message')

                </div>
            </div>

            <div class="box-footer">
                {!! Form::open(['route' => 'haberesListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
                <input type="hidden" value="{{$estadoPeriodo->id}}" name="periodo">
                <input type="submit"
                       class="btn btn-default"
                       value='Volver'/>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection



