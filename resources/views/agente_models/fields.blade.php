<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Apellido Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellido', 'Apellido:') !!}
    {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
</div>

<!-- Dni Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! Form::number('dni', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Nacimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_nacimiento', 'Fecha Nacimiento:') !!}
    {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control']) !!}
</div>

<!-- Cuit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cuit', 'Cuit:') !!}
    {!! Form::text('cuit', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Base Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_base', 'Id Base:') !!}
    {!! Form::number('id_base', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_area', 'Id Area:') !!}
    {!! Form::number('id_area', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Domicilio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_domicilio', 'Id Domicilio:') !!}
    {!! Form::number('id_domicilio', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Contrato Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_contrato', 'Id Contrato:') !!}
    {!! Form::number('id_contrato', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Dias Disponibles Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_dias_disponibles', 'Id Dias Disponibles:') !!}
    {!! Form::number('id_dias_disponibles', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Estudio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_estudio', 'Id Estudio:') !!}
    {!! Form::number('id_estudio', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('agenteModels.index') !!}" class="btn btn-default">Cancel</a>
</div>
