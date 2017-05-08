<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $diaDisponible->id !!}</p>
</div>

<!-- Id Tipo Presentismo Field -->
<div class="form-group">
    {!! Form::label('id_tipo_presentismo', 'Id Tipo Presentismo:') !!}
    <p>{!! $diaDisponible->id_tipo_presentismo !!}</p>
</div>

<!-- Cant Dias Field -->
<div class="form-group">
    {!! Form::label('cant_dias', 'Cant Dias:') !!}
    <p>{!! $diaDisponible->cant_dias !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $diaDisponible->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $diaDisponible->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $diaDisponible->deleted_at !!}</p>
</div>

