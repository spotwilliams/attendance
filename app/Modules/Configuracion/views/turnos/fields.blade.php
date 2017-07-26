<!-- Codigo Field -->
<div class="form-group col-sm-6 @if($errors->has('codigo')) has-error @endif">
    {!! Form::label('codigo', 'C&oacute;digo:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
    @if($errors->has('codigo'))
        <span class="help-block">{{$errors->first('codigo')}}</span>
    @endif
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6 @if($errors->has('descripcion')) has-error @endif">
    {!! Form::label('descripcion', 'Descripci&oacute;n:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
    @if($errors->has('descripcion'))
        <span class="help-block">{{$errors->first('descripcion')}}</span>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('configuracion.turno.index') !!}" class="btn btn-default">Cancelar</a>
</div>
