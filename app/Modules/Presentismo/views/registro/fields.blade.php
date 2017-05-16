<!-- Id Agente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_agente', 'Id Agente:') !!}
    {!! Form::number('id_agente', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Jornada Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_jornada', 'Id Jornada:') !!}
    {!! Form::number('id_jornada', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Tipo Presentismo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_tipo_presentismo', 'Id Tipo Presentismo:') !!}
    {!! Form::number('id_tipo_presentismo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Padre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_padre', 'Id Padre:') !!}
    {!! Form::number('id_padre', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('presentismos.index') !!}" class="btn btn-default">Cancel</a>
</div>
