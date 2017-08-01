<?php

$funciones = \Cat\Repositories\FuncionRepository::getAll();
?>

<div class="form-group @if($errors->has('funcion')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione una funci&oacute;n
        @endif
    </label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" name="funcion" data-live-search="true">
            <option value="-1">...</option>
            @foreach ($funciones as $f)
                <option value="{{ $f->id }}"
                        @if(isset($funcion) and ($funcion->id === $f->id)) selected @endif>{{$f->nombre}}
                </option>
            @endforeach
        </select>
        @if($errors->has('funcion'))
            <span class="help-block">{{$errors->first('funcion')}}</span>
        @endif
    </div>
</div>


