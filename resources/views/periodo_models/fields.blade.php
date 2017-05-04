<!-- Fecha Comienzo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_comienzo', 'Fecha Comienzo:') !!}
    {!! Form::date('fecha_comienzo', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Fin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_fin', 'Fecha Fin:') !!}
    {!! Form::date('fecha_fin', null, ['class' => 'form-control']) !!}
</div>

<!-- Cant Dias Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cant_dias', 'Cant Dias:') !!}
    {!! Form::number('cant_dias', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('periodoModels.index') !!}" class="btn btn-default">Cancel</a>
</div>
