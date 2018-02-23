@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Modificaci&oacute;n de monto de contrato y fecha</h3>
            </div>
            <div class="box-body">
                @include('Haberes::modificador.form')
            </div>
        </div>
    </div>

@endsection
