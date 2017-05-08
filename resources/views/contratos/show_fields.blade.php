<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $contratos->id !!}</p>
</div>

<!-- Tipo Contrato Field -->
<div class="form-group">
    {!! Form::label('tipo_contrato', 'Tipo Contrato:') !!}
    <p>{!! $contratos->tipo_contrato !!}</p>
</div>

<!-- Fecha Firma Field -->
<div class="form-group">
    {!! Form::label('fecha_firma', 'Fecha Firma:') !!}
    <p>{!! $contratos->fecha_firma !!}</p>
</div>

<!-- Fecha Comienzo Field -->
<div class="form-group">
    {!! Form::label('fecha_comienzo', 'Fecha Comienzo:') !!}
    <p>{!! $contratos->fecha_comienzo !!}</p>
</div>

<!-- Id Estado Contrato Field -->
<div class="form-group">
    {!! Form::label('id_estado_contrato', 'Id Estado Contrato:') !!}
    <p>{!! $contratos->id_estado_contrato !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $contratos->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $contratos->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $contratos->deleted_at !!}</p>
</div>

