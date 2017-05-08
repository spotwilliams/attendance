<!-- Id Tipo Presentismo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_tipo_presentismo', 'Id Tipo Presentismo:') !!}
    {!! Form::number('id_tipo_presentismo', null, ['class' => 'form-control']) !!}
</div>

<!-- Cant Dias Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cant_dias', 'Cant Dias:') !!}
    {!! Form::number('cant_dias', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('diaDisponibles.index') !!}" class="btn btn-default">Cancel</a>
</div>
