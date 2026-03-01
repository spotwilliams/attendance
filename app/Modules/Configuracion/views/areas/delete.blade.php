@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Eliminar &aacute;rea
                </h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        @include('Configuracion::areas.show_fields')
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route('configuracion.area.destroy', $area->id) }}" method="POST">@csrf @method('DELETE')

                        <button type="submit" class="btn btn-danger" @if(!$area->operativos->isEmpty()) disabled @endif>
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                        <a class="btn btn-default" href="{{route('configuracion.area.index')}}">Volver</a>
                        <p class="help-block">S&oacute;lo las &aacute;reas sin agentes asignados pueden ser eliminadas</p>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <hr>


                        <h4>Listado de agentes pertenecientes a la &aacute;rea</h4>
                        <div class="table-responsive">

                            @include('Configuracion::areas.table-agentes')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection