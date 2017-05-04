<!-- Institucion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('institucion', 'Institucion:') !!}
    {!! Form::text('institucion', null, ['class' => 'form-control']) !!}
</div>

<!-- Carrera Field -->
<div class="form-group col-sm-6">
    {!! Form::label('carrera', 'Carrera:') !!}
    {!! Form::text('carrera', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Comentario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comentario', 'Comentario:') !!}
    {!! Form::text('comentario', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('estudioModels.index') !!}" class="btn btn-default">Cancel</a>
</div>
