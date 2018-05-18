@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Control del presentismo</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12 col-xs-12 col-lg-12">
                    @include('Reportes::haberes-vista-previa.form-general')
                </div>

            </div>
        </div>
        @include('Reportes::haberes-vista-previa.result.lista')

    </div>
@endsection

