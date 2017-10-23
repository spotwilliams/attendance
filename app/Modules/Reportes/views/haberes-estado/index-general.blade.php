@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Reporte de peri&oacute;dos y estado</h3>
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
        $(document).ready(function () {
            $('table').dataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                scrollY: "700px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: true,
                dom: 'Bfrtip',
            });
            {{--@if(isset($exportar))--}}
            {{--var exportButton = $('{!! $exportar !!}');--}}
            //                exportButton.children('[type="submit"]').removeClass('btn btn-default').addClass('dt-button buttons-colvisGroup');
            //                $('.dt-buttons').append(exportButton);
            {{--@endif--}}
        })
    </script>
@append