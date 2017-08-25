<?php
$tipo = (isset($tipo) ? $tipo : new \Cat\Models\TipoPresentismo());
if ((isset($tipo->diasPermitidos) and !$tipo->diasPermitidos->isEmpty())) {
    $meses = $tipo->diasPermitidos;
} else {
    $meses = new \Illuminate\Support\Collection([

        [
            'mes_ingreso'     => 'JULY',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
        [
            'mes_ingreso'     => 'AUGUST',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
        [
            'mes_ingreso'     => 'SEPTEMBER',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
        [
            'mes_ingreso'     => 'OCTOBER',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
        [
            'mes_ingreso'     => 'NOVEMBER',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
        [
            'mes_ingreso'     => 'DECEMBER',
            'cant_semanal'    => 0,
            'cant_fin_semana' => 0,
        ],
    ]);
}
?>
<input type="hidden" name="id" value="{{$tipo->id}}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group @if($errors->has('codigo')) has-error @endif ">
            {!! Form::label('codigo', 'C&oacute;digo:') !!}
            {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
            @if($errors->has('codigo'))
                <span class="help-block">{{$errors->first('codigo')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('descripcion')) has-error @endif ">
            {!! Form::label('descripcion', 'Nombre:') !!}
            {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
            @if($errors->has('descripcion'))
                <span class="help-block">{{$errors->first('descripcion')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('color')) has-error @endif ">

            {!! Form::label('color', 'Color:') !!}
            {!! Form::text('color', null, ['class' => 'form-control color-p']) !!}
            @if($errors->has('color'))
                <span class="help-block">{{$errors->first('color')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('color_letra')) has-error @endif ">

            {!! Form::label('color_letra', 'Color de letra:') !!}
            {!! Form::text('color_letra', null, ['class' => 'form-control color-p']) !!}
            @if($errors->has('color_letra'))
                <span class="help-block">{{$errors->first('color_letra')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('aplica')) has-error @endif ">

            {!! Form::label('aplica', 'Aplica a:') !!}
            {!! Form::select('aplica', [
            'TODOS' => 'Todos los tipos de contratos',
            'SITUACION_REVISTA' => 'Contratos situaci&oacute;n de revista',
            'LOCACION' => 'Contratos de locaci&oacute;n',
            ], null, ['class' => 'form-control']) !!}
            @if($errors->has('aplica'))
                <span class="help-block">{{$errors->first('aplica')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('injustificado')) has-error @endif ">

            {!! Form::label('injustificado', 'Injustificado:') !!}
            {!! Form::select('injustificado', [
            '1' => 'Si',
            '0' => 'No',
            ], null, ['class' => 'form-control']) !!}
            @if($errors->has('injustificado'))
                <span class="help-block">{{$errors->first('injustificado')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('dias_permitidos')) has-error @endif ">
            {!! Form::label('dias_permitidos', 'Cantidad de d&iacute;as permitidos:') !!}
            {!! Form::text('dias_permitidos', $meses[0]['cant_semanal'], ['class' => 'form-control']) !!}
            @if($errors->has('dias_permitidos'))
                <span class="help-block">{{$errors->first('dias_permitidos')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('tiene_tope')) has-error @endif ">

            {!! Form::label('tiene_tope', 'Tiene tope:') !!}
            <select name="tiene_tope" class="form-control">
                <option value="1"
                        @if((isset($tipo->diasPermitidos) and !$tipo->diasPermitidos->isEmpty())) selected @endif>Si
                </option>
                <option value="0">No</option>
            </select>

            @if($errors->has('tiene_tope'))
                <span class="help-block">{{$errors->first('tiene_tope')}}</span>
            @endif

        </div>


        <!-- Submit Field -->

    </div>
    <div class="col-md-6">
        <table class="table dataTable meses">
            <thead>
            <tr>
                <th>Mes ingreso</th>
                <th>Turno semanal</th>
                <th>Turno fin de semana</th>
            </tr>
            </thead>
            <tbody>

            @foreach($meses as $mes)
                @if($mes['mes_ingreso'] !== 'JULY')
                    <tr>
                        <th>{{trans('month.'.$mes['mes_ingreso'])}}</th>
                        <td class="{{trans('month.'.$mes['mes_ingreso'])}} semana">{{$mes['cant_semanal']}}</td>
                        <td class="{{trans('month.'.$mes['mes_ingreso'])}} finde">{{$mes['cant_fin_semana']}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>


        </table>
    </div>
    <div class="form-group col-sm-10 pull-right">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('configuracion.licencia.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".color-p").colorpicker();

            $('select[name="tiene_tope"]').on('change', function (event) {
                if ($(this).val() == 1) {
                    $('input[name="dias_permitidos"]').prop('disabled', false);
                    $('.table.meses').show();
                } else {
                    $('input[name="dias_permitidos"]').prop('disabled', true);
                    $('.table.meses').hide();
                }
            })

            $('input[name="dias_permitidos"]').on('keyup', function (event) {

                var meses = [
                    @foreach($meses as $mes)
                        '{{trans('month.'.$mes['mes_ingreso'])}}',
                    @endforeach
                ];
                var prop = 0;
                for (var i = 0; i < meses.length; i++) {
                    if ($.isNumeric($(this).val())) {
                        prop = Math.ceil($(this).val() / 12) * (12 - (i + 6));
                    } else {
                        prop = 0;
                    }
                    $('.table.meses').find('td.' + meses[i]).html(prop);
                }
            })

        })
    </script>
@append