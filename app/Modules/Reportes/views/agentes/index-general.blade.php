<?php
if (!isset($agentes)) {
    $agentes = new \Illuminate\Support\Collection();
}

?>
@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Reporte de personal</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 col-xs-12 col-lg-12">
                    @include('Reportes::agentes.form-general')
                </div>
                <hr/>
                <div class="col-md-12 col-xs-12 table-responsive">

                    <table class="table table-hover">

                        <thead>
                        @include('Reportes::agentes.result.table-header')
                        </thead>
                        <tbody>
                        @include('Reportes::agentes.result.table-content')
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer text-center">
                @if(!$agentes->isEmpty())
                    {{$links}}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').dataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'colvisGroup',
                        text: 'Datos personales',
                        show: [0, 1, 2, 3, 5, 7],
                        hide: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24]
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Datos laborales',
                        show: [8, 9, 10, 11, 12, 13, 14],
                        hide: [0, 1, 2, 3, 4, 5, 6, 7, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24]
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Datos operativos',
                        show: [15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
                        hide: [0, 1, 2, 3, 4, 5,6, 7, 8, 9, 10, 11, 12, 13, 14]
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Mostrar todo',
                        show: ':hidden'
                    },
                ]
            });
            var exportButton = $('{!! $exportar !!}');
            exportButton.children('[type="submit"]').removeClass('btn btn-default').addClass('dt-button buttons-colvisGroup');
            $('.dt-buttons').append(exportButton);
        })
    </script>
@append