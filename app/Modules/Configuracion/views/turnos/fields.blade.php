<!-- Codigo Field -->
<div class="form-group col-sm-6 @if($errors->has('codigo')) has-error @endif">
    <label for="codigo">C&oacute;digo:</label>
    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" class="form-control">
    @if($errors->has('codigo'))
        <span class="help-block">{{$errors->first('codigo')}}</span>
    @endif
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6 @if($errors->has('descripcion')) has-error @endif">
    <label for="descripcion">Descripci&oacute;n:</label>
    <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="form-control">
    @if($errors->has('descripcion'))
        <span class="help-block">{{$errors->first('descripcion')}}</span>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{!! route('configuracion.turno.index') !!}" class="btn btn-default">Cancelar</a>
</div>
