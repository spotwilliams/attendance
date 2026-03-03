<?php
use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;
use Cat\Models\Contrato;
$idEstadosContratosBaja = array_keys(
    EstadoContrato::getEstadosEquivalentesBajas()->keyBy('id')->toArray()
);
$idTiposContratosLocacion = array_keys(
    TipoContrato::getEquivalentesLocacion()->keyBy('id')->toArray()
);
$_comision = EstadoContrato::comision();
$_comisionId = $_comision ? $_comision->id : null;

if (!isset($contrato)) {
    $contrato = new Contrato([
        'id_tipo_contrato'   => (int)old('id_tipo_contrato'),
        'id_estado_contrato' => (int)old('id_estado_contrato'),
    ]);
}
if (old('id_tipo_contrato')) {
    $contrato->id_tipo_contrato = (int)old('id_tipo_contrato');
}
if (old('id_estado_contrato')) {
    $contrato->id_estado_contrato = (int)old('id_estado_contrato');
}

?>
<input type="hidden" name="id" id="id" value="{{ old('id') }}">

<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <span class="progress-text">Paso 2</span>
        <span class="progress-number"><b>2</b>/3</span>

        <div class="progress">
            <div class="progress-bar progress-bar-yellow" style="width: 66%"></div>
        </div>
    </div>
</div>
<input type="hidden" name="agente" value="{{$agente->id}}">


<div class="panel panel-default">
    <div class="panel-body">
        <?php
        $tipos[-1] = 'Seleccione';
        foreach (\Cat\Models\TipoContrato::all(['id', 'descripcion'])->toArray() as $est) {
            $tipos[$est['id']] = $est['descripcion'];
        }
        ?>

        <div class="form-group @if($errors->has('id_tipo_contrato')) has-error @endif">
            <label class="col-sm-3 control-label">Tipo de modalidad *</label>
            <div class="col-sm-8">
                <select name="id_tipo_contrato" id="id_tipo_contrato" class="form-control">
                    @foreach($tipos as $val => $label)
                        <option value="{{ $val }}" {{ old('id_tipo_contrato') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_tipo_contrato'))
                    <span class="help-block">{{$errors->first('id_tipo_contrato')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group @if($errors->has('fecha_ingreso')) has-error @endif">
            <label class="col-sm-3 control-label">Fecha de ingreso modalidad actual *</label>
            <div class="col-sm-8">
                <input type="hidden" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}">
                <input type="text" name="fecha_ingreso_show" class="form-control">
                @if($errors->has('fecha_ingreso'))
                    <span class="help-block">{{$errors->first('fecha_ingreso')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group @if($errors->has('fecha_fin')) has-error @endif es-locacion @if(!in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
            <label class="col-sm-3 control-label">Fecha de fin modalidad actual *</label>
            <div class="col-sm-8">
                <input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}">
                <input type="text" name="fecha_fin_show" class="form-control">
                @if($errors->has('fecha_fin'))
                    <span class="help-block">{{$errors->first('fecha_fin')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group es-situacion-revista @if(in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
            <label class="col-sm-3 control-label">ID Sial</label>
            <div class="col-sm-8">
                <input type="text" name="id_sial" id="id_sial" value="{{ old('id_sial') }}" class="form-control">
            </div>
        </div>

        <div class="form-group es-situacion-revista @if(in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
            <label class="col-sm-3 control-label">Ficha</label>
            <div class="col-sm-8">
                <input type="text" name="ficha" id="ficha" value="{{ old('ficha') }}" class="form-control">
            </div>
        </div>

        <div class="form-group @if($errors->has('tipo_inscripcion')) has-error @endif es-locacion @if(!in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
            <label class="col-sm-3 control-label">Tipo de inscripci&oacute;n IIBB * </label>
            <div class="col-sm-8">
                <select name="tipo_inscripcion" id="tipo_inscripcion" class="form-control">
                    @foreach([
                '-1' => 'Seleccione',
                'Regimen simplificado' => 'R&eacute;gimen simplificado',
                 'Convenio multilareral' => 'Convenio multilareral',
                  'Regimen general' => 'R&eacute;gimen general'
                  ] as $val => $label)
                        <option value="{{ $val }}" {{ old('tipo_inscripcion') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tipo_inscripcion'))
                    <span class="help-block">{{$errors->first('tipo_inscripcion')}}</span>
                @endif

            </div>
        </div>

    </div>
</div>


<!--
Lo referido a los estados de contrato

-->
<div class="panel panel-default">
    <div class="panel-body">

        <?php
        $estados[-1] = 'Seleccione';
        foreach (\Cat\Models\EstadoContrato::all(['id', 'descripcion'])->toArray() as $est) {
            $estados[$est['id']] = $est['descripcion'];
        }
        ?>


        <div class="form-group @if($errors->has('id_estado_contrato')) has-error @endif">
            <label class="col-sm-3 control-label">Estado *</label>
            <div class="col-sm-8">
                <select name="id_estado_contrato" id="id_estado_contrato" class="form-control">
                    @foreach($estados as $val => $label)
                        <option value="{{ $val }}" {{ old('id_estado_contrato') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_estado_contrato'))
                    <span class="help-block">{{$errors->first('id_estado_contrato')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group es-baja @if(!in_array($contrato->id_estado_contrato, $idEstadosContratosBaja)) hidden @endif @if($errors->has('fecha_estado_desde')) has-error @endif">
            <label class="col-sm-3 control-label">Fecha de baja</label>
            <div class="col-sm-8">
                <input type="hidden" name="fecha_estado_desde" id="fecha_estado_desde" value="{{ old('fecha_estado_desde') }}">
                <input type="text" name="fecha_estado_desde_show" class="form-control">
                @if($errors->has('fecha_estado_desde'))
                    <span class="help-block">{{$errors->first('fecha_estado_desde')}}</span>
                @endif
            </div>
        </div>
        {{--

        Desde / Hasta comision

        --}}
        {{--<p class="help-block col-md-offset-2">Se asignar&aacute; presentismo 'Eximido' durante los d&iacute;as establecidos.</p>--}}
        <div class="form-group es-comision @if(!$_comisionId || $contrato->id_estado_contrato !== $_comisionId) hidden @endif @if($errors->has('fecha_estado_desde')) has-error @endif">
            <label class="col-sm-3 control-label">En comisi&oacute;n desde *</label>
            <div class="col-sm-8">
                <input type="hidden" name="fecha_estado_desde" id="fecha_estado_desde" value="{{ old('fecha_estado_desde') }}">
                <input type="text" name="fecha_estado_desde_show" class="form-control">
                @if($errors->has('fecha_estado_desde'))
                    <span class="help-block">{{$errors->first('fecha_estado_desde')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group es-comision @if($contrato->id_estado_contrato !== $_comisionId) hidden @endif @if($errors->has('fecha_estado_hasta')) has-error @endif">
            <label class="col-sm-3 control-label">En comisi&oacute;n hasta *</label>
            <div class="col-sm-8">
                <input type="hidden" name="fecha_estado_hasta" id="fecha_estado_hasta" value="{{ old('fecha_estado_hasta') }}">
                <input type="text" name="fecha_estado_hasta_show" class="form-control">
                @if($errors->has('fecha_estado_hasta'))
                    <span class="help-block">{{$errors->first('fecha_estado_hasta')}}</span>
                @endif
            </div>
        </div>
        <div class="form-group
                    @if(!in_array($contrato->id_estado_contrato, $idEstadosContratosBaja) and $contrato->id_estado_contrato !== $_comisionId) hidden @endif
        @if($errors->has('comentario')) has-error @endif
                ">
            <label class="col-sm-3 control-label es-baja @if(!in_array($contrato->id_estado_contrato, $idEstadosContratosBaja)) hidden @endif ">Comentario
                de baja</label>
            <label class="col-sm-3 control-label es-comision @if($contrato->id_estado_contrato !== $_comisionId) hidden @endif">Comentario
                de comisi&oacute;n * </label>
            <div class="col-sm-8">
                <textarea name="comentario" id="comentario" class="form-control">{{ old('comentario') }}</textarea>
                @if($errors->has('comentario'))
                    <span class="help-block">{{$errors->first('comentario')}}</span>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group @if($errors->has('fecha_ingreso_gobierno')) has-error @endif">
    <label class="col-sm-3 control-label">Fecha de ingreso al GCBA * </label>
    <div class="col-sm-8">
        <input type="hidden" name="fecha_ingreso_gobierno" id="fecha_ingreso_gobierno" value="{{ old('fecha_ingreso_gobierno') }}">
        <input type="text" name="fecha_ingreso_gobierno_show" class="form-control">

        @if($errors->has('fecha_ingreso_gobierno'))
            <span class="help-block">{{$errors->first('fecha_ingreso_gobierno')}}</span>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">Monto</label>
    <div class="col-sm-8">
        <input type="text" name="monto" id="monto" value="{{ old('monto') }}" class="form-control" placeholder="16002">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Siguiente</button>
        <a href="{{route('agentesEditPersonales', ['id' => $agente])}}" class="btn btn-default col-sm-offset-8">Atr&aacute;s</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
            $('[name="id_tipo_contrato"]').on('change', function () {
                var optionsLocacion = {{json_encode( $idTiposContratosLocacion)}};
                // Locacion de servicio
                if ($.inArray(parseInt($(this).val()), optionsLocacion) !== -1) {

                    $('.es-situacion-revista').fadeOut(400);
                    $('.es-locacion')
                        .fadeIn(400)
                        .removeClass('hidden');
                } else {
                    $('.es-situacion-revista').fadeIn(400)
                        .removeClass('hidden');
                    $('.es-locacion').fadeOut(400);

                }
            });
            /**
             *
             *
             *  Comportanmiento en estado Contrato
             *
             *
             */
            $('[name="id_estado_contrato"]').on('change', function (event) {


                var comentario = $('textarea[name="comentario"]').parents('.form-group').first();

                comentario
                    .removeClass('hidden')
                    .fadeOut(400);

                var optionsBaja = {{json_encode( $idEstadosContratosBaja)}};
                var continuarCon = true;
                // Activos
                if ($.inArray(parseInt($(this).val()), optionsBaja) !== -1) {
                    $('.es-baja')
                        .fadeIn(400)
                        .removeClass('hidden');

                    $('.es-baja')
                        .fadeIn(400)
                        .removeClass('hidden');

                    comentario.fadeIn(400)
                        .removeClass('hidden');
                    continuarCon = false;
                } else {
                    $('.es-baja')
                        .fadeOut(400);
                }

                // En comision
                if (continuarCon && ($(this).val() === '{{$_comisionId}}')) {
                    $('.es-comision')
                        .fadeIn(400)
                        .removeClass('hidden');

                    comentario.fadeIn(400)
                        .removeClass('hidden');
                } else {
                    $('.es-comision')
                        .fadeOut(400);

                }
            });

            setupDate($('[name="fecha_estado_desde"]'), $('[name="fecha_estado_desde_show"]'))
            setupDate($('[name="fecha_estado_hasta"]'), $('[name="fecha_estado_hasta_show"]'))
            setupDate($('[name="fecha_estado_desde"]'), $('[name="fecha_estado_desde_show"]'))
            setupDate($('[name="fecha_ingreso"]'), $('[name="fecha_ingreso_show"]'))
            setupDate($('[name="fecha_fin"]'), $('[name="fecha_fin_show"]'))
            setupDate($('[name="fecha_ingreso_gobierno"]'), $('[name="fecha_ingreso_gobierno_show"]'))
        });


        function setupDate(element, complement) {
            var day = moment('{{date('Y')}}-01-01');

            if ($(element).val() === '') {
                $(element).val(day.format('Y-MM-DD'));
            } else {
                day = moment($(element).val());
            }

            var locale = {
                format: 'DD/MM/YYYY',
                separator: " - ",
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                fromLabel: "Desde",
                toLabel: "Hasta",
                weekLabel: "W",
                daysOfWeek: [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mie",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
            };

            $(complement)
                .val(day.format('DD/MM/YYYY'))
                .daterangepicker({
                        locale: locale,
                        showDropdowns: true,
                        singleDatePicker: true,
                        opens: 'center',
                    },
                    function (start, end, label) {
                        $(element).val(start.format('Y-MM-DD'))
                    });

        }
    </script>
@append
