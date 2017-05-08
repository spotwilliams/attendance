<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Periodo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_periodo', 'Id Periodo:') !!}
    {!! Form::number('id_periodo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jornadaLaborables.index') !!}" class="btn btn-default">Cancel</a>
</div>
