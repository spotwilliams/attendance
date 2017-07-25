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
                <h3 class="box-title">B&uacute;squeda de datos de personal</h3>
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

