<!-- Direccion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Gerencia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gerencia', 'Gerencia:') !!}
    {!! Form::text('gerencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Subgerencia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subgerencia', 'Subgerencia:') !!}
    {!! Form::text('subgerencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('areasModels.index') !!}" class="btn btn-default">Cancel</a>
</div>
