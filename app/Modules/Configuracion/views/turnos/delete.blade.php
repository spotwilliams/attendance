@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Eliminar turno
                </h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        @include('Configuracion::turnos.show_fields')
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route('configuracion.turno.destroy', $turnoModel->id) }}" method="POST">@csrf @method('DELETE')

                        <button type="submit" class="btn btn-danger" @if(!$turnoModel->operativos->isEmpty()) disabled @endif>
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                        <a class="btn btn-default" href="{{route('configuracion.turno.index')}}">Volver</a>

                        <p class="help-block">S&oacute;lo los turnos sin agentes asignados pueden ser eliminados</p>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <hr>


                        <h4>Listado de agentes pertenecientes al turno</h4>
                        <div class="table-responsive">

                            @include('Configuracion::turnos.table-agentes')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection