@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de agentes</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10">
                        @include('bases.select' , ['routeName'=>'agentesIndex', 'label'=> 'Base actual', 'baseSeleccionada' => $baseActual])
                    </div>
                    <div class="col-md-2">
                        @include('Agentes::registro.commons.nuevo-btn')
                    </div>
                </div>
                @include('Agentes::registro.table')
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">

                    {{$agentes->links()}}
                </div>

            </div>
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

