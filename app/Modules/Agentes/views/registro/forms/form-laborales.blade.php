{!! Form::hidden('id', null, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <span class="progress-text">Paso 2</span>
        <span class="progress-number"><b>2</b>/3</span>

        <div class="progress">
            <div class="progress-bar progress-bar-yellow" style="width: 66%"></div>
        </div>
    </div>
</div>
<input type="hidden" name="agente" value="{{$agente}}">
<?php
$tipos[-1] = 'Seleccione';
foreach (\Cat\Models\TipoContrato::all(['id', 'descripcion'])->toArray() as $est) {
    $tipos[$est['id']] = $est['descripcion'];
}
?>

<div class="form-group @if($errors->has('id_tipo_contrato')) has-error @endif">
    <label class="col-sm-2 control-label">Modalidad contractual</label>
    <div class="col-sm-8">
        {!! Form::select('id_tipo_contrato',  $tipos, null, ['class' => 'form-control']) !!}
        @if($errors->has('id_tipo_contrato'))
            <span class="help-block">{{$errors->first('id_tipo_contrato')}}</span>
        @endif
    </div>
</div>


<?php
$estados[-1] = 'Seleccione';
foreach (\Cat\Models\EstadoContrato::all(['id', 'descripcion'])->toArray() as $est) {
    $estados[$est['id']] = $est['descripcion'];
}
?>


<div class="form-group @if($errors->has('id_estado_contrato')) has-error @endif">
    <label class="col-sm-2 control-label">Estado de contrato</label>
    <div class="col-sm-8">
        {!! Form::select('id_estado_contrato',  $estados, null, ['class' => 'form-control']) !!}
        @if($errors->has('id_estado_contrato'))
            <span class="help-block">{{$errors->first('id_estado_contrato')}}</span>
        @endif
    </div>
</div>
<div class="form-group hidden">
    <label class="col-sm-2 control-label">ID Sial</label>
    <div class="col-sm-8">
        {!! Form::text('id_sial', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group hidden">
    <label class="col-sm-2 control-label">Ficha</label>
    <div class="col-sm-8">
        {!! Form::text('ficha', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group @if($errors->has('fecha_ingreso')) has-error @endif">
    <label class="col-sm-2 control-label">Fecha de ingreso</label>
    <div class="col-sm-8">
        {!! Form::date('fecha_ingreso', null, ['class' => 'form-control']) !!}
        @if($errors->has('fecha_ingreso'))
            <span class="help-block">{{$errors->first('fecha_ingreso')}}</span>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Monto</label>
    <div class="col-sm-8">
        {!! Form::text('monto', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Siguiente', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
            $('[name="id_tipo_contrato"]').on('change', function () {

                // Locacion de servicio
                if ($(this).val() == 7 || $(this).val() == 8) {
                    $('[name="id_sial"]').parents().closest('.form-group').addClass('hidden');
                    $('[name="ficha"]').parents().closest('.form-group').addClass('hidden');
                } else {
                    $('[name="id_sial"]').parents().closest('.form-group').removeClass('hidden');
                    $('[name="ficha"]').parents().closest('.form-group').removeClass('hidden');

                }
            })
        });
    </script>
@append