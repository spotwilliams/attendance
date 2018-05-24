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

            <div class="box-body">

                <div class="col-md-12">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 1</span>
                            <span class="progress-number"><b>1</b>/3</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>


                    @include('Haberes::calculo.parts.form-filtros')
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Resultados de la b&uacute;squeda: <span class="label label-info">@if(isset($agentes)){{$agentes->total()}}@else{{0}}@endif</span> agentes encontrados</h3>
            </div>

            <div class="box-body">

                <div class="col-md-12">

                    @include('Haberes::calculo.parts.table')
                </div>

            </div>
        </div>
    </div>
@endsection



