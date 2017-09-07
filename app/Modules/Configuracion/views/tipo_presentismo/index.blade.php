@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Listado de tipos de licencias</h3>
                <div class="pull-right">
                    <a class="btn btn-success pull-right" href="{!! route('configuracion.licencia.create') !!}">Agregar nuevo</a>
                </div>
            </div>
            <div class="box-body">
                    @include('Configuracion::tipo_presentismo.table')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tp-table').dataTable({});
        })
    </script>
    @append