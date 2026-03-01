<input type="hidden" name="id" id="id" value="{{ old('id') }}">
<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <div class="progress-group">
            <span class="progress-text">Paso 3</span>
            <span class="progress-number"><b>3</b>/3</span>

            <div class="progress">
                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="agente" value="{{$agente->id}}">

<?php
$gerencias = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Gerencia::whereNull('id_padre')->get(['id', 'nombre']) as $geren) {
    /** @var \Cat\Models\Gerencia $geren */
    /** @var \Cat\Models\Gerencia $subgerencia */
    $gerencias[$geren->nombre] = [
        $geren->id => $geren->nombre
    ];

    foreach ($geren->hijas()->get(['id', 'nombre']) as $subgerencia) {
        $gerencias[$geren->nombre] [$subgerencia->id] = $subgerencia->nombre;
    }
}

?>

<div class="form-group">
    <label class="col-sm-2 control-label">Gerencia/Subgerencia</label>
    <div class="col-sm-8">
        <select name="id_gerencia" id="id_gerencia" class="form-control" data-live-search="true">
            @foreach($gerencias as $val => $label)
                <option value="{{ $val }}" {{ old('id_gerencia') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<?php
$areas = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Area::orderBy('nombre', 'ASC')->get() as $a) {
    /** @var \Cat\Models\Area $a */
    $areas[$a->id] = $a->nombre;
}

?>


<div class="form-group">
    <label class="col-sm-2 control-label">&Aacute;rea</label>
    <div class="col-sm-8">
        <select name="id_area" id="id_area" class="form-control" data-live-search="true">
            @foreach($areas as $val => $label)
                <option value="{{ $val }}" {{ old('id_area') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

    </div>
</div>

<?php
$cargos = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Cargo::all() as $c) {
    /** @var \Cat\Models\Area $a */
    $cargos[$c->id] = $c->nombre;
}

?>

<div class="form-group">
    <label class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-8">
        <select name="id_cargo" id="id_cargo" class="form-control" data-live-search="true">
            @foreach($cargos as $val => $label)
                <option value="{{ $val }}" {{ old('id_cargo') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<?php
$funciones = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Funcion::all() as $funcion) {
    $funciones[$funcion->id] = $funcion->nombre;
}
?>

<div class="form-group @if($errors->has('id_funcion')) has-error @endif">
    <label class="col-sm-2 control-label">Funci&oacute;n*</label>
    <div class="col-sm-8">
        <select name="id_funcion" id="id_funcion" class="form-control" data-live-search="true">
            @foreach($funciones as $val => $label)
                <option value="{{ $val }}" {{ old('id_funcion') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        @if($errors->has('id_funcion'))
            <span class="help-block">{{$errors->first('id_funcion')}}</span>
        @endif
    </div>
</div>
<?php
$funcionEspecifica = [
    'Operador',
    'Apoyo Operativo',
    'Actas',
    'Coordinador',
    'Gerente',
    'Subgerente',
    'Apoyo Operativo',
    'Jefe de Base',
    'Abogada',
    'Agente de Tránsito',
    'Agente de Tránsito/Motos',
    'Agente de Tránsito/Alcoholemia',
    'Apoyo Operativo',
    'Chofer',
    'Chofer Dirección',
    'Delegado',
    'Mecánico',
    'Motos',
    'Motos/Alcoholemia',
];
$funcion = (isset($operativo) ? $operativo->funcion_especifica : 'Operador');
?>
<div class="form-group">
    <label class="col-sm-2 control-label">Funci&oacute;n espec&iacute;fica</label>
    <div class="col-sm-8">
        <select class="form-control" id="funcion-especifica-select" data-live-search="true">
            @foreach($funcionEspecifica as $fe)
                <option value="{{$fe}}" @if($funcion === $fe) selected @endif>{{$fe}}</option>
            @endforeach
            <option value="Otro" @if(!in_array($funcion, $funcionEspecifica)) selected @endif>
                Otro
            </option>
        </select>
    </div>
</div>
<div class="form-group funcion-especifica-show @if(in_array($funcion, $funcionEspecifica)) hidden @endif ">
    <div class="col-md-offset-2 col-sm-8">
        <input type="hidden" name="funcion_especifica" id="funcion_especifica" value="{{ old('funcion_especifica') }}">
        <input type="text" name="funcion_especifica_show" id="funcion_especifica_show" value="{{ old('funcion_especifica_show') }}" class="form-control">
        <p class="help-block">Agregue una funci&oacute;n espec&iacute;fica que no est&eacute; listada</p>
    </div>
</div>


<?php
$bases = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Base::orderBy('nombre', 'ASC')->get() as $b) {
    /** @var \Cat\Models\Area $a */
    $bases[$b->id] = $b->nombre;
}
?>
<div class="form-group @if($errors->has('id_base')) has-error @endif">
    <label class="col-sm-2 control-label">Base*</label>
    <div class="col-sm-8">
        <select name="id_base" id="id_base" class="form-control" data-live-search="true">
            @foreach($bases as $val => $label)
                <option value="{{ $val }}" {{ old('id_base') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        @if($errors->has('id_base'))
            <span class="help-block">{{$errors->first('id_base')}}</span>
        @endif
    </div>
</div>

<?php
$turnos = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Turno::orderBy('codigo', 'ASC')->get() as $t) {
    /** @var \Cat\Models\Area $a */
    $turnos[$t->id] = $t->codigo;
}
?>
<div class="form-group @if($errors->has('id_turno')) has-error @endif">
    <label class="col-sm-2 control-label">Turno*</label>
    <div class="col-sm-8">
        <select name="id_turno" id="id_turno" class="form-control" data-live-search="true">
            @foreach($turnos as $val => $label)
                <option value="{{ $val }}" {{ old('id_turno') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @if($errors->has('id_turno'))
            <span class="help-block">{{$errors->first('id_turno')}}</span>
        @endif
    </div>
</div>

<?php

/** @var \Cat\Models\Horario $horario */
$horario = (isset($operativo) ? $operativo->horario()->first() : null);
$horaEntrada = isset($horario) ? $horario->hora_entrada : '00:00';
$horaSalida = isset($horario) ? $horario->hora_salida : '00:00';
?>
<div class="form-group">
    <label class="col-sm-2 control-label">Horario*</label>
    <div class="col-sm-10">
        <div class="col-sm-2 @if($errors->has('hora_entrada')) has-error @endif">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" name="hora_entrada" id="hora_entrada" value="{{ old('hora_entrada', $horaEntrada) }}" class="form-control horario">
                @if($errors->has('hora_entrada'))
                    <span class="help-block">{{$errors->first('hora_entrada')}}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-2 @if($errors->has('hora_salida')) has-error @endif">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" name="hora_salida" id="hora_salida" value="{{ old('hora_salida', $horaSalida) }}" class="form-control horario" placeholder="00:00">

                @if($errors->has('hora_salida'))
                    <span class="help-block">{{$errors->first('hora_salida')}}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="col-md-4">Rotativo</label>
                <div class="col-md-6">
                    <select name="rotativo" id="rotativo" class="form-control hora-especial">
                        @foreach([0 => 'No', 1 => 'Si'] as $val => $label)
                            <option value="{{ $val }}" {{ old('rotativo') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="col-md-4">Eximido</label>
                <div class="col-md-6">
                    <select name="eximido" id="eximido" class="form-control hora-especial">
                        @foreach([0 => 'No', 1 => 'Si'] as $val => $label)
                            <option value="{{ $val }}" {{ old('eximido') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-smnull0">
        <button type="submit" class="btn btn-primary">Finalizar</button>
        <a href="{{route('agentesEditLaborales', ['id' => $agente])}}" class="btn btn-default col-sm-offset-8">Atr&aacute;s</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
            $('.horario').timepicker({'timeFormat': 'H:i'});

            $('.hora-especial').on('change', function () {

                if ($(this).val() == 1) {
                    $('.horario').attr('disabled', true);
                } else {
                    $('.horario').attr('disabled', false);

                }
            });

            $('#funcion-especifica-select').on('change', function () {
                $('[name="funcion_especifica"]').val($(this).val());
                if ($(this).val() === 'Otro') {
                    $('.funcion-especifica-show').fadeIn(400);
                    $('.funcion-especifica-show').removeClass('hidden');
                } else {
                    $('.funcion-especifica-show').fadeOut(400);

                }
            });

            $('[name="funcion_especifica_show"]').val($('[name="funcion_especifica"]').val());

            $('[name="funcion_especifica_show"]').keyup(function () {
                $('[name="funcion_especifica"]').val($(this).val());
            });

        });
    </script>
@append
