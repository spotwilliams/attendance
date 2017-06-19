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

foreach (\Cat\Models\Area::all() as $a) {
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

foreach (\Cat\Models\Funcion::whereNull('id_padre')->get(['id', 'nombre']) as $funcion) {

    foreach ($funcion->hijas()->get(['id', 'nombre']) as $f) {
        $funciones[$funcion->nombre] [$f->id] = $f->nombre;
    }
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

<div class="form-group">
    <label class="col-sm-2 control-label">Funci&oacute;n espec&iacute;fica</label>
    <div class="col-sm-8">
        {!! Form::text('funcion_especifica', null, ['class' => 'form-control']) !!}
    </div>
</div>


<?php
$bases = [-1 => 'Seleccione...'];

foreach (\Cat\Models\Base::all() as $b) {
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

foreach (\Cat\Models\Turno::all() as $t) {
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


<div class="form-group">
    <label class="col-sm-2 control-label">Horario*</label>
    <div class="col-sm-10">
        <div class="col-sm-2 @if($errors->has('hora_entrada')) has-error @endif">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                {!! Form::text('hora_entrada', '00:00', ['class' => 'form-control horario', ]) !!}
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
                {!! Form::text('hora_salida', '00:00', ['class' => 'form-control horario', 'placeholder' => '00:00']) !!}

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
            })
        });
    </script>
@append