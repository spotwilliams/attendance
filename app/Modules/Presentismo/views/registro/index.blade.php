@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h3 class="box-title">Carga de presentismo</h3>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                @include('bases.select' ,['label'=> 'Base actual', 'baseSeleccionada' => $baseActual])

            </div>
            <div class="box-body">
                @include('Presentismo::registro.table')
            </div>
        </div>
    </div>
@endsection

