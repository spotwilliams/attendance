<!-- Tipo Contrato Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipo_contrato', 'Tipo Contrato:') !!}
    {!! Form::text('tipo_contrato', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Firma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_firma', 'Fecha Firma:') !!}
    {!! Form::date('fecha_firma', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Comienzo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_comienzo', 'Fecha Comienzo:') !!}
    {!! Form::date('fecha_comienzo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Estado Contrato Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_estado_contrato', 'Id Estado Contrato:') !!}
    {!! Form::number('id_estado_contrato', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('contratos.index') !!}" class="btn btn-default">Cancel</a>
</div>
