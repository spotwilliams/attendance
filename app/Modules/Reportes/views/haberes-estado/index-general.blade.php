@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Resumen de haberes</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 col-xs-12 col-lg-12">
                    @include('Reportes::haberes-estado.form-general')
                </div>
            </div>
        </div>
        @include('Reportes::haberes-estado.result.display')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $('select')
            .data('actions-box', true)
            .selectpicker({});
        $(document).ready(function () {


        })
    </script>
@append