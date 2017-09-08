<?php

/** @var \Illuminate\Support\Collection $meses */

$tipo                = (isset($tipo) ? $tipo : new \Cat\Models\TipoPresentismo());
$tipo->injustificado = ($tipo->injustificado) ? 1 : 0;
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

$meses = $meses->keyBy('mes_ingreso')->toArray();

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
            <div class="checkbox checkbox-info checkbox-circle">
                <input type="checkbox" class="selectable" id="colores_por_defecto">
                <label for="colores_por_defecto">
                    Usar colores por defecto
                </label>
            </div>
            <div class="input-group colorpicker-component color-p">
                {!! Form::text('color', null, ['class' => 'form-control']) !!}
                <span class="input-group-addon"><i></i></span>

            </div>
            @if($errors->has('color'))
                <span class="help-block">{{$errors->first('color')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('color_letra')) has-error @endif ">

            {!! Form::label('color_letra', 'Color de letra:') !!}
            <div class="input-group colorpicker-component color-p">
                {!! Form::text('color_letra', null, ['class' => 'form-control']) !!}
                <span class="input-group-addon"><i></i></span>
            </div>
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

    </div>
    <div class="col-md-6">
        <div class="form-group @if($errors->has('tiene_tope')) has-error @endif ">

            {!! Form::label('tiene_tope', 'Tiene tope:') !!}
            <select name="tiene_tope" class="form-control">
                <option value="1"
                        @if(old('tiene_tope')) selected @endif
                >Si
                </option>
                <option value="0"
                        @if((!old('tiene_tope'))and (!isset($tipo->diasPermitidos) or ($tipo->diasPermitidos->isEmpty()))) selected @endif
                >No
                </option>
            </select>

            @if($errors->has('tiene_tope'))
                <span class="help-block">{{$errors->first('tiene_tope')}}</span>
            @endif

        </div>

        <div class="form-group @if($errors->has('cant_semanal')) has-error @endif col-md-6">
            {!! Form::label('cant_semanal', 'D&iacute;as para turno semanal:') !!}
            {!! Form::text('cant_semanal', $meses['JULY']['cant_semanal'], ['class' => 'form-control']) !!}
            @if($errors->has('cant_semanal'))
                <span class="help-block">{{$errors->first('cant_semanal')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('cant_fin_semana')) has-error @endif col-md-6">
            {!! Form::label('cant_fin_semana', 'D&iacute;as para fin de semana:') !!}
            {!! Form::text('cant_fin_semana', $meses['JULY']['cant_fin_semana'], ['class' => 'form-control']) !!}
            @if($errors->has('cant_fin_semana'))
                <span class="help-block">{{$errors->first('cant_fin_semana')}}</span>
            @endif
        </div>

        <table class="table dataTable meses">
            <thead>
            <tr>
                <th>Mes ingreso</th>
                <th>Turno semanal</th>
                <th>Turno fin de semana</th>
            </tr>
            </thead>
            <tbody>

            @foreach($meses as $mes => $dias)
                @if($mes !== 'JULY')
                    <tr>
                        <th>{{trans('month.'.$mes)}}</th>
                        <td class="{{trans('month.'.$mes)}} semana">{{$dias['cant_semanal']}}</td>
                        <td class="{{trans('month.'.$mes)}} finde">{{$dias['cant_fin_semana']}}</td>
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
            // Primer control
            updateScreem($('select[name="tiene_tope"]').val());

            $(".color-p").colorpicker();

            function updateScreem(tieneTope) {

                if (tieneTope == 1) {
                    $('input[name="cant_semanal"], input[name="cant_fin_semana"]')
                        .prop('disabled', false);
                    updateProporcionales($('input[name="cant_semanal"]'))
                    updateProporcionales($('input[name="cant_fin_semana"]'))
                    $('.table.meses').show();
                } else {
                    $('input[name="cant_semanal"], input[name="cant_fin_semana"]')
                        .val(0)
                        .prop('disabled', true);

                    $('.table.meses').hide();
                }
            }

            function updateProporcionales(element) {
                var meses = [
                    @foreach($meses as $mes => $dias)
                        '{{trans('month.'.$mes)}}',
                    @endforeach
                ];
                var prop = 0;
                var who = $(element).prop('name') === 'cant_semanal' ? 'semana' : 'finde';
                for (var i = 1; i <= meses.length; i++) {
                    if ($.isNumeric($(element).val())) {
                        prop = Math.ceil($(element).val() / 12 * (12 - (i + 6)));
                    } else {
                        prop = 0;
                    }
                    $('.table.meses').find('td.' + meses[i] + '.' + who).html(prop);
                }
            }


            $('select[name="tiene_tope"]').on('change', function (event) {
                updateScreem($(this).val());

            });

            $('#colores_por_defecto').on('change', function (eve) {
                if ($(this).prop('checked') === true) {
                    $('input[name="color"]').val('#4d70a8');
                    $('input[name="color_letra"]').val('#333');

                    var colors = $('.color-p');

                    $(colors[0]).colorpicker('setValue', '#4d70a8');
                    $(colors[1]).colorpicker('setValue', '#333')
                } else {
                    $('input[name="color"]').val('');
                    $('input[name="color_letra"]').val('');

                    var colors = $('.color-p');

                    $(colors[0]).colorpicker('setValue', '');
                    $(colors[1]).colorpicker('setValue', '')
                }

            });

            $('input[name="cant_semanal"], input[name="cant_fin_semana"]').on('keyup', function (event) {
                updateProporcionales(this);
            })


        })
    </script>
@append