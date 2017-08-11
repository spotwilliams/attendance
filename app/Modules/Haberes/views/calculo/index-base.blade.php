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
            {!! Form::open(['route' => 'haberesSelectPeriodo', 'class'=>'form-horizontal', 'method' => 'POST']) !!}

            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 1</span>
                            <span class="progress-number"><b>1</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                        @include('common.bases.as-select-sin-btn' ,[ 'label'=> 'Seleccione la base', 'baseSeleccionada' => -1])
                        @include('common.turnos.as-select' ,[ 'label'=> 'Seleccione el turno', 'baseSeleccionada' => -1])
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('select').attr('data-live-search', true).selectpicker({});
        })
    </script>
@append


