@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h3 class="box-title">Lista de agentes</h3>
    </section>
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                @include('bases.select' , ['routeName'=>'agentesIndex', 'label'=> 'Base actual', 'baseSeleccionada' => $baseActual])
                <a href="{{route('agentesCreatePersonales')}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Agregar Agente</a>
            </div>
            <div class="box-body">
                @include('Agentes::registro.table')
            </div>
        </div>
    </div>
@endsection

