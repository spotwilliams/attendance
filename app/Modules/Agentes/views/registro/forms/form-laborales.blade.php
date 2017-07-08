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
if (!isset($contrato)) {
    $contrato = new Contrato();
}
?>
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
    <label class="col-sm-2 control-label">Modalidad contractual *</label>
    <div class="col-sm-8">
        {!! Form::select('id_tipo_contrato',  $tipos, null, ['class' => 'form-control']) !!}
        @if($errors->has('id_tipo_contrato'))
            <span class="help-block">{{$errors->first('id_tipo_contrato')}}</span>
        @endif
    </div>
</div>
<div class="form-group es-situacion-revista @if(in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
    <label class="col-sm-2 control-label">ID Sial</label>
    <div class="col-sm-8">
        {!! Form::text('id_sial', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group es-situacion-revista @if(in_array($contrato->id_tipo_contrato, $idTiposContratosLocacion)) hidden @endif">
    <label class="col-sm-2 control-label">Ficha</label>
    <div class="col-sm-8">
        {!! Form::text('ficha', null, ['class' => 'form-control']) !!}
    </div>
</div>

<?php
$estados[-1] = 'Seleccione';
foreach (\Cat\Models\EstadoContrato::all(['id', 'descripcion'])->toArray() as $est) {
    $estados[$est['id']] = $est['descripcion'];
}
?>


<div class="form-group @if($errors->has('id_estado_contrato')) has-error @endif">
    <label class="col-sm-2 control-label">Estado de contrato *</label>
    <div class="col-sm-8">
        {!! Form::select('id_estado_contrato',  $estados, null, ['class' => 'form-control']) !!}
        @if($errors->has('id_estado_contrato'))
            <span class="help-block">{{$errors->first('id_estado_contrato')}}</span>
        @endif
    </div>
</div>

<div class="form-group es-baja @if(!in_array($contrato->id_estado_contrato, $idEstadosContratosBaja)) hidden @endif @if($errors->has('fecha_baja')) has-error @endif">
    <label class="col-sm-2 control-label">Fecha de baja</label>
    <div class="col-sm-8">
        {!! Form::date('fecha_baja', null, ['class' => 'form-control']) !!}
        @if($errors->has('fecha_baja'))
            <span class="help-block">{{$errors->first('fecha_baja')}}</span>
        @endif
    </div>
</div>

<div class="form-group es-baja @if(!in_array($contrato->id_estado_contrato, $idEstadosContratosBaja)) hidden @endif">
    <label class="col-sm-2 control-label">Comentario de baja</label>
    <div class="col-sm-8">
        {!! Form::textarea('comentario_baja', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group @if($errors->has('tipo_inscripcion')) has-error @endif es-locacion">
    <label class="col-sm-2 control-label">Tipo de inscripci&oacute;n IIBB * </label>
    <div class="col-sm-8">
        {!! Form::select('tipo_inscripcion',  [
        '-1' => 'Seleccione',
        'Regimen simplificado' => 'R&eacute;gimen simplificado',
         'Convenio multilareral' => 'Convenio multilareral',
          'Regimen general' => 'R&eacute;gimen general'
          ], null, ['class' => 'form-control']) !!}
        @if($errors->has('tipo_inscripcion'))
            <span class="help-block">{{$errors->first('tipo_inscripcion')}}</span>
        @endif

    </div>
</div>

<div class="form-group @if($errors->has('fecha_ingreso')) has-error @endif es-locacion">
    <label class="col-sm-2 control-label">Fecha alta de contrato *</label>
    <div class="col-sm-8">
        {!! Form::date('fecha_ingreso', null, ['class' => 'form-control']) !!}
        @if($errors->has('fecha_ingreso'))
            <span class="help-block">{{$errors->first('fecha_ingreso')}}</span>
        @endif
    </div>
</div>
<div class="form-group @if($errors->has('fecha_ingreso_gobierno')) has-error @endif">
    <label class="col-sm-2 control-label">Fecha de ingreso al GCBA</label>
    <div class="col-sm-8">
        {!! Form::date('fecha_ingreso_gobierno', null, ['class' => 'form-control']) !!}
        @if($errors->has('fecha_ingreso_gobierno'))
            <span class="help-block">{{$errors->first('fecha_ingreso_gobierno')}}</span>
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
                var optionsLocacion = {{json_encode( $idTiposContratosLocacion)}};
                // Locacion de servicio
                for (var i = 0; i < optionsLocacion.length; i++) {
                    if ($(this).val() == optionsLocacion[i]) {

                        $('.es-situacion-revista').fadeOut(400);
                        $('.es-locacion').fadeIn(400);
                        break;
                    } else {
                        $('.es-situacion-revista').fadeIn(400);
                        $('.es-locacion').fadeOut(400);

                    }
                }
            });
            $('[name="id_estado_contrato"]').on('change', function (event) {
                var optionsBaja = {{json_encode( $idEstadosContratosBaja)}};
                for (var i = 0; i < optionsBaja.length; i++) {
                    if ($(this).val() == optionsBaja[i]) {
                        $('.es-baja').removeClass('hidden');
                        break;
                    } else {
                        $('.es-baja').addClass('hidden');
                    }
                }
            })
        });
    </script>
@append