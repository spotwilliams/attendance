@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Modificaci&oacute;n contratos de Locaci&oacute;n</h3>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">

                        <div class="form-group">
                            <div class="progress-group">
                                <span class="progress-text">Paso 1</span>
                                <span class="progress-number"><b>1</b>/2</span>

                                <div class="progress">
                                    <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('Haberes::modificador.form')
            </div>
        </div>
    </div>

@endsection
