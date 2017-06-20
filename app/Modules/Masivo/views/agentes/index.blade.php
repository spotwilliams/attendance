@extends('layouts.app')

@section('content')

    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Carga de agentes masiva</h3>

            </div>
            {!! Form::open(['route' => 'agentesMasivoUpload', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}
            <div class="box-body">
                <div class="form-group">
                    @include('bases.select-sin-btn' , ['routeName'=>'agentesIndex', 'label'=> 'Seleccione la base', 'baseSeleccionada' => -1])
                </div>

                <div class="form-group @if($errors->has('archivo')) has-error @endif">
                    <label for="archivo" class="col-sm-3 col-xs-3 control-label">Seleccione el archivo</label>
                    {{--<input type="file" id="archivo" name="archivo" class="col-sm-6">--}}
                    <div class="col-sm-9 col-xs-9">
                        {!! Form::file('archivo', ['class'=>'filestyle' ,'data-buttonName'=>'btn-primary'])!!}
                        @if($errors->has('archivo'))
                            <span class="help-block col-sm-12">{{$errors->first('archivo')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Subir y procesar', ['class' => 'btn btn-primary pull-right']) !!}
                <p class="help-block pull-left">Ingrese un archivo xls(Excel) acorde al formato permitido.
                    <a class="btn btn-default btn-xs">Ver instrucciones</a>
                </p>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="instrucciones hidden">
            @include('Masivo::agentes.advertisment')
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('p.help-block > a').on('click', function (elem, event) {

                $('.instrucciones').removeClass('hidden');
            })
        })
    </script>
@append