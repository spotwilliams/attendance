<!-- Nombre Field -->
<div class="form-group col-sm-6 @if($errors->has('nombre')) has-error @endif ">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control">
    @if($errors->has('nombre'))
        <span class="help-block">{{$errors->first('nombre')}}</span>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{!! route('configuracion.area.index') !!}" class="btn btn-default">Cancelar</a>
</div>
