@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Eliminar base
                </h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        @include('Configuracion::bases.show_fields')
                    </div>
                    <div class="col-md-8">
                        {!! Form::open(['route' => ['configuracion.base.destroy', $baseModel->id],'method' => 'delete']) !!}

                        <button type="submit" class="btn btn-danger" @if(!$baseModel->operativos->isEmpty()) disabled @endif>
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                        <a class="btn btn-default" href="{{route('configuracion.base.index')}}">Volver</a>

                        <p class="help-block">S&oacute;lo las bases sin agentes asignados pueden ser eliminadas</p>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-12">
                        <hr>


                        <h4>Listado de agentes pertenecientes a la base</h4>
                        <div class="table-responsive">

                            @include('Configuracion::bases.table-agentes')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection