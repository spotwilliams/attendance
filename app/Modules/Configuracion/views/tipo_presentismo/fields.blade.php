<?php

/** @var \Illuminate\Support\Collection $meses */

$tipo = (isset($tipo) ? $tipo : new \Cat\Models\TipoPresentismo());
$tipo->injustificado = ($tipo->injustificado) ? 1 : 0;
$tipo->es_fijo = ($tipo->es_fijo) ? 1 : 0;
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
            <label for="codigo">C&oacute;digo:</label>
            <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" class="form-control">
            @if($errors->has('codigo'))
                <span class="help-block">{{$errors->first('codigo')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('descripcion')) has-error @endif ">
            <label for="descripcion">Nombre:</label>
            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="form-control">
            @if($errors->has('descripcion'))
                <span class="help-block">{{$errors->first('descripcion')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('color')) has-error @endif ">

            <label for="color">Color:</label>
            <div class="checkbox checkbox-info checkbox-circle">
                <input type="checkbox" class="selectable" id="colores_por_defecto">
                <label for="colores_por_defecto">
                    Usar colores por defecto
                </label>
            </div>
            <div class="input-group colorpicker-component color-p">
                <input type="text" name="color" id="color" value="{{ old('color') }}" class="form-control">
                <span class="input-group-addon"><i></i></span>

            </div>
            @if($errors->has('color'))
                <span class="help-block">{{$errors->first('color')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('color_letra')) has-error @endif ">

            <label for="color_letra">Color de letra:</label>
            <div class="input-group colorpicker-component color-p">
                <input type="text" name="color_letra" id="color_letra" value="{{ old('color_letra') }}" class="form-control">
                <span class="input-group-addon"><i></i></span>
            </div>
            @if($errors->has('color_letra'))
                <span class="help-block">{{$errors->first('color_letra')}}</span>
            @endif
        </div>
        <?php
        $attrs = '';
        if (isset($aplicaDisabled) and $aplicaDisabled == true) {
            $attrs  = 'style=" display:none;"';

        }
        ?>
        <div class="form-group @if($errors->has('aplica')) has-error @endif" {!! $attrs !!}>

            <label for="aplica">Aplica a:</label>
            <select name="aplica" id="aplica" class="form-control">
                @foreach([
                'TODOS' => 'Todos los tipos de contratos',
                'SITUACION_REVISTA' => 'Contratos situaci&oacute;n de revista',
                'LOCACION' => 'Contratos de locaci&oacute;n',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ old('aplica') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('aplica'))
                <span class="help-block">{{$errors->first('aplica')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('injustificado')) has-error @endif col-md-4">

            <label
                    data-toggle="popover"
                    data-trigger="hover"
                    title="Estado"
                    data-content="Indica en qu&eacute; estado se guardar&aacute; por defecto la licencia (como Justificada o Injustificada)"
            >Valor inicial: </label>
            <select name="injustificado" id="injustificado" class="form-control">
                @foreach([
                '1' => 'Injustificado',
                '0' => 'Justificado',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ old('injustificado') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('injustificado'))
                <span class="help-block">{{$errors->first('es_fijo')}}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('es_fijo')) has-error @endif col-md-4">

            <label
                    data-toggle="popover"
                    data-trigger="hover"
                    title="Justificabilidad"
                    data-content="En caso de 'No', implica que la licencia puede ser justificable o no, caso contrario no podr&aacute; cambiarse su estado (similar a Ausente, Presente, Feriados, etc.)"
            >Fijo: </label>
            <select name="es_fijo" id="es_fijo" class="form-control">
                @foreach([
                '0' => 'No',
                '1' => 'Si',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ old('es_fijo') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('es_fijo'))
                <span class="help-block">{{$errors->first('es_fijo')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('tiene_proporcional')) has-error @endif col-md-4"
             style="display: none;">

            <label
                    data-toggle="popover"
                    data-trigger="hover"
                    title="Justificabilidad"
                    data-content="En caso de 'No', implica que la licencia no tiene valores proporcionales a los meses de ingreso"
            >Tiene proporcional: </label>
            <select name="tiene_proporcional" id="tiene_proporcional" class="form-control">
                @foreach([
                '-1' => 'N/A',
                '0' => 'No',
                '1' => 'Si',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ old('tiene_proporcional') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('tiene_proporcional'))
                <span class="help-block">{{$errors->first('tiene_proporcional')}}</span>
            @endif
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group @if($errors->has('tiene_tope')) has-error @endif ">

            <label for="tiene_tope">Tiene tope:</label>
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
            <label for="cant_semanal">D&iacute;as para turno semanal:</label>
            <input type="text" name="cant_semanal" id="cant_semanal" value="{{ old('cant_semanal', $meses['JULY']['cant_semanal']) }}" class="form-control">
            @if($errors->has('cant_semanal'))
                <span class="help-block">{{$errors->first('cant_semanal')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('cant_fin_semana')) has-error @endif col-md-6">
            <label for="cant_fin_semana">D&iacute;as para fin de semana:</label>
            <input type="text" name="cant_fin_semana" id="cant_fin_semana" value="{{ old('cant_fin_semana', $meses['JULY']['cant_fin_semana']) }}" class="form-control">
            @if($errors->has('cant_fin_semana'))
                <span class="help-block">{{$errors->first('cant_fin_semana')}}</span>
            @endif
        </div>

        <table class="table dataTable meses" style="display: none;">
            <thead>
            <tr>
                <th>Mes ingreso</th>
                <th>Turno semanal</th>
                <th>Turno fin de semana</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Agosto</th>
                <td class="Agosto semana">{{$meses['AUGUST']['cant_semanal']}}</td>
                <td class="Agosto finde">{{$meses['AUGUST']['cant_fin_semana']}}</td>
            </tr>
            <tr>
                <th>Septiembre</th>
                <td class="Septiembre semana">{{$meses["SEPTEMBER"]['cant_semanal']}}</td>
                <td class="Septiembre finde">{{$meses["SEPTEMBER"]['cant_fin_semana']}}</td>
            </tr>
            <tr>
                <th>Octubre</th>
                <td class="Octubre semana">{{$meses["OCTOBER"]['cant_semanal']}}</td>
                <td class="Octubre finde">{{$meses["OCTOBER"]['cant_fin_semana']}}</td>
            </tr>
            <tr>
                <th>Noviembre</th>
                <td class="Noviembre semana">{{$meses["NOVEMBER"]['cant_semanal']}}</td>
                <td class="Noviembre finde">{{$meses["NOVEMBER"]['cant_fin_semana']}}</td>
            </tr>
            <tr>
                <th>Diciembre</th>
                <td class="Diciembre semana">{{$meses["DECEMBER"]['cant_semanal']}}</td>
                <td class="Diciembre finde">{{$meses["DECEMBER"]['cant_fin_semana']}}</td>
            </tr>

            </tbody>


        </table>
    </div>
    <div class="form-group col-sm-10 pull-right">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{!! route('configuracion.licencia.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var esFijo = verificarSiEsFijo();
            // Primer control

            updateScreem($('select[name="tiene_tope"]').val(), false, esFijo);

            $(".color-p").colorpicker();

            function updateScreem(tieneTope, actualizarProporcional, esFijoOn) {

                if (tieneTope == 1) {
                    $('input[name="cant_semanal"], input[name="cant_fin_semana"]')
                        .prop('disabled', false);
                    if (actualizarProporcional === undefined || actualizarProporcional !== false) {
                        updateProporcionales($('input[name="cant_semanal"]'));
                        updateProporcionales($('input[name="cant_fin_semana"]'));
                    }
                    if ($('select[name="aplica"]').val() == 'SITUACION_REVISTA') {
                        // Los proporcionales solo son para locacion
                        $('.table.meses').hide();
                        $('select[name="tiene_proporcional"]').parent().hide();
                    } else {
                        $('select[name="tiene_proporcional"]').parent().show();
                        $('.table.meses').show();
                    }
                    $('select[name="tiene_proporcional"]').val(-1);
                } else {
                    $('input[name="cant_semanal"], input[name="cant_fin_semana"]')
                        .val(0)
                        .prop('disabled', true);

                    $('select[name="tiene_proporcional"]').parent().hide();
                    $('select[name="tiene_proporcional"]').val(-1);
                    $('.table.meses').hide();
                }
                if (esFijoOn !== undefined && esFijoOn !== false) {

                    $('select[name="tiene_proporcional"]')
                        .val(0)
                        .trigger('change')
                    ;
                    $('.table.meses').hide();
                }

            }

            function updateProporcionales(element, esFijo) {
                var meses = [
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre',
                ];

                var prop = 0;
                var who = $(element).prop('name') === 'cant_semanal' ? 'semana' : 'finde';
                for (var i = 1; i <= meses.length; i++) {
                    if ($.isNumeric($(element).val())) {
                        if (esFijo !== undefined && esFijo === true) {
                            prop = Math.ceil($(element).val());
                        } else {
                            prop = Math.ceil($(element).val() / 12 * (12 - (i + 6)));
                        }
                    } else {
                        prop = 0;
                    }
                    $('.table.meses').find('td.' + meses[i] + '.' + who).html(prop);
                }
            }

            function verificarSiEsFijo() {
                var findeValues = $('td.finde');
                var semanaValues = $('td.semana');

                var reference = $(findeValues[0]).html();
                var changeValue = false;
                for (var i = 0; i < findeValues.length; i++) {
                    if (reference !== $(findeValues[0]).html()) {
                        changeValue = true;
                        break;
                    }
                }

                var reference2 = $(semanaValues[0]).html();
                var changeValue2 = false;
                for (var i = 0; i < semanaValues.length; i++) {
                    if (reference2 !== $(semanaValues[0]).html()) {
                        changeValue2 = true;
                    }
                }
                // el valor se establacio como fijo
                return (!changeValue || !changeValue2);
            }

            $('select[name="tiene_tope"]').on('change', function (event) {
                updateScreem($(this).val());

            });
            $('select[name="aplica"]').on('change', function (event) {
                updateScreem($('select[name="tiene_tope"]').val());

            });
            $('select[name="tiene_proporcional"]').on('change', function (event) {
                // Debo calcular los proporcionales
                switch ($(this).val()) {
                    case '1' : {
                        updateProporcionales($('input[name="cant_semanal"]'));
                        updateProporcionales($('input[name="cant_fin_semana"]'));
                        $('.table.meses').show();
                        break;
                    }
                    case '0' : {
                        $('.table.meses').hide();
                        // Debo mantener los valores fijos
                        updateProporcionales($('input[name="cant_semanal"]'), true);
                        updateProporcionales($('input[name="cant_fin_semana"]'), true);
                        break;
                    }
                    case '-1': {
//                        $('.table.meses').show();
                        break;
                    }
                    default: {
                        break;
                    }
                }

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

            $('[data-toggle="popover"]').popover({});


        })
    </script>
@append