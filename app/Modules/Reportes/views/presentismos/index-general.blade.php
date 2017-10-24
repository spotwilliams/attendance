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
                <h3 class="box-title">Reporte de asistencias</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 col-xs-12 col-lg-12">
                    @include('Reportes::presentismos.form-general')
                </div>
                <hr/>
                <div class="col-md-12 col-xs-12 table-responsive">
                    @if(!$agentes->isEmpty())
                        <h4 class="box-tools pull-left">Se encontraron <span class="label label-info">{{$agentes->total()}}</span> agentes</h4>
                    @endif
                    <table class="table table-hover">
                        <thead>
                        @include('Reportes::common.days-header')
                        </thead>
                        <tbody>
                        @include('Reportes::common.days-content')
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
                scrollY:        "700px",
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns: true,

            });
        })
    </script>
@append