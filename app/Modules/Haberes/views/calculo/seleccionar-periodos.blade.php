@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">C&aacute;lculo de haberes</h3>
            </div>

            <div class="box-body text-center">

                <div class="col-md-8 col-md-offset-2">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 1 - Seleccionar periodo</span>
                            <span class="progress-number"><b>1</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>


                    @include('Haberes::calculo.parts.form-periodos')
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>

    </div>
@endsection



