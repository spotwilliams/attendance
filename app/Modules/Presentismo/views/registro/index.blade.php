@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Carga de presentismo</h3>
            </div>
            <div class="box-body">
                @include('bases.select' ,['routeName'=>'presentismoIndex', 'label'=> 'Base actual', 'baseSeleccionada' => $baseActual])
                <hr>
                @include('Presentismo::registro.table')
            </div>
        </div>
    </div>
@endsection

