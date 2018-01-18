@extends('layouts.app')


@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Migraci&oacute;n de presentismos masiva</h3>
            </div>

            {!! Form::open(['route' => 'presentismosMasivoMigracionUpload', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}

            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">
                    <div class="form-group">
                        <div class="progress-group col-sm-8 col-sm-offset-2">
                            <span class="progress-text">Paso 1</span>
                            <span class="progress-number"><b>1</b>/2</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('archivo')) has-error @endif">
                        <label for="archivo" class="col-sm-3 col-xs-3 control-label">Archivo completo</label>
                        <div class="col-sm-9 col-xs-9">
                            {!! Form::file('archivo', ['class'=>'filestyle' ,'data-buttonName'=>'btn-primary'])!!}
                            @if($errors->has('archivo'))
                                <span class="help-block col-sm-12 col-xs-12">{{$errors->first('archivo')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Subir y procesar', ['class' => 'btn btn-primary pull-right']) !!}
                <a href="{{route('presentismosMasivoMigracionIndex')}}" class="btn btn-default col-sm-offset-2">Atr&aacute;s</a>

            </div>
            {!! Form::close() !!}
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
