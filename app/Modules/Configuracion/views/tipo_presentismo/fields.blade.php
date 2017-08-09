<!-- Nombre Field -->
<div class="form-group col-sm-6 @if($errors->has('nombre')) has-error @endif ">
    {!! Form::label('codigo', 'C&oacute;digo:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}

    {!! Form::label('descripcion', 'Descripci&oacute;n:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}

    {!! Form::label('color', 'Color:') !!}
    {!! Form::text('color', null, ['class' => 'form-control color-p']) !!}

    {!! Form::label('color_letra', 'Color de letra:') !!}
    {!! Form::text('color_letra', null, ['class' => 'form-control color-p']) !!}

    {!! Form::label('aplica', 'Aplica a:') !!}
    {!! Form::select('aplica', [
    'TODOS' => 'Todos los tipos de contratos',
    'SITUACION_REVISTA' => 'Contratos situaci&oacute;n de revista',
    'LOCACION' => 'Contratos de locaci&oacute;n',
    ], null, ['class' => 'form-control']) !!}

    {!! Form::label('injustificado', 'Injustificado:') !!}

    <select class="form-control" name="injustificado">
        <option value="1">Si</option>
        <option value="0" @if((isset($tipo) and ($tipo->injustificado===false))) selected @endif>No</option>
    </select>

    @if($errors->has('nombre'))
        <span class="help-block">{{$errors->first('nombre')}}</span>
    @endif
</div>
<div class="form-group col-sm-6">
    <label class="col-md-12">Cantidad de d&iacute;as permitidos</label>
    @foreach($tipo->diasPermitidos as $dia)
        <div class="row">
            {!! Form::label($dia->mes_ingreso,$dia->mes_ingreso ,['class' => 'text-right  col-md-3']) !!}

            <div class="col-md-8 form-horizontal">
                <label class="col-md-6">Turno semanal</label>
                <input name="{{$dia->mes_ingreso}}" class="form-control col-md-6" value="{{$dia->cant_semanal}}">
                {{--<label>Turno fin de semana</label>--}}
                {{--<input name="{{$dia->mes_ingreso}}" class="form-control col-md-3" value="{{$dia->cant_fin_semana}}">--}}
            </div>
        </div>
    @endforeach
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('configuracion.licencia.index') !!}" class="btn btn-default">Cancelar</a>
</div>


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".color-p").colorpicker();
        })
    </script>
@append