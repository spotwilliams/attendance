<!-- Calle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('calle', 'Calle:') !!}
    {!! Form::text('calle', null, ['class' => 'form-control']) !!}
</div>

<!-- Numero Field -->
<div class="form-group col-sm-6">
    {!! Form::label('numero', 'Numero:') !!}
    {!! Form::text('numero', null, ['class' => 'form-control']) !!}
</div>

<!-- Deptartamento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deptartamento', 'Deptartamento:') !!}
    {!! Form::text('deptartamento', null, ['class' => 'form-control']) !!}
</div>

<!-- Piso Field -->
<div class="form-group col-sm-6">
    {!! Form::label('piso', 'Piso:') !!}
    {!! Form::text('piso', null, ['class' => 'form-control']) !!}
</div>

<!-- Barrio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('barrio', 'Barrio:') !!}
    {!! Form::text('barrio', null, ['class' => 'form-control']) !!}
</div>

<!-- Provincia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('provincia', 'Provincia:') !!}
    {!! Form::text('provincia', null, ['class' => 'form-control']) !!}
</div>

<!-- Libre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('libre', 'Libre:') !!}
    {!! Form::text('libre', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('domicilioModels.index') !!}" class="btn btn-default">Cancel</a>
</div>
