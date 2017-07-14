{!! Form::hidden('id', null, ['class' => 'form-control']) !!}
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

<input type="hidden" name="agente" value="{{$agente}}">

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
        {!! Form::select('id_gerencia',  $gerencias, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}
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
        {!! Form::select('id_area',  $areas, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}

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
        {!! Form::select('id_cargo',  $cargos, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}
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
        {!! Form::select('id_funcion',  $funciones, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}

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
        {!! Form::hidden('funcion_especifica') !!}
        {!! Form::text('funcion_especifica_show', null, ['class' => 'form-control']) !!}
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
        {!! Form::select('id_base',  $bases, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}

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
        {!! Form::select('id_turno',  $turnos, null, ['class' => 'form-control', 'data-live-search'=>'true']) !!}
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
                {!! Form::text('hora_entrada', $horaEntrada, ['class' => 'form-control horario', ]) !!}
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
                {!! Form::text('hora_salida', $horaSalida, ['class' => 'form-control horario', 'placeholder' => '00:00']) !!}

                @if($errors->has('hora_salida'))
                    <span class="help-block">{{$errors->first('hora_salida')}}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="col-md-4">Rotativo</label>
                <div class="col-md-6">
                    {!! Form::select('rotativo',  [0 => 'No', 1 => 'Si'], null, ['class' => 'form-control hora-especial', ]) !!}
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="col-md-4">Eximido</label>
                <div class="col-md-6">
                    {!! Form::select('eximido',  [0 => 'No', 1 => 'Si'], null, ['class' => 'form-control hora-especial', ]) !!}
                </div>

            </div>
        </div>
    </div>

</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-smnull0">
        {!! Form::submit('Finalizar', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
            $('.horario').timepicker({});

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