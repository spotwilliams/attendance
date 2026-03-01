@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Fecha de cierre de periodo
                </h3>
            </div>
            <div class="box-body">
                @include('flash::message')

                <div class="row">
                <form action="{{ route('configuracion.fecha.cierre.update') }}" method="POST">@csrf
                <!-- Nombre Field -->
                    <div class="form-group col-sm-6 @if($errors->has('dia')) has-error @endif ">
                        <label for="dia">Seleccione el d&iacute;a a mostrar:</label>
                        <select class="form-control" name="dia">
                            @for($i = 1; $i< 31; $i++)
                                <option value="{{$i}}" @if($i == $fecha->valor) selected @endif>{{$i}}</option>
                            @endfor
                        </select>
                        @if($errors->has('dia'))
                            <span class="help-block">{{$errors->first('dia')}}</span>
                        @endif
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="/" class="btn btn-default">Cancelar</a>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').selectpicker();
        })
    </script>
@append