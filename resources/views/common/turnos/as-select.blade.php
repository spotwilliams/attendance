<?php

$turnos = \Cat\Repositories\TurnosRepository::getAll();
?>

<div class="form-group @if($errors->has('turno')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el turno
        @endif
    </label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" name="turno" data-live-search="true">
            <option value="-1">...</option>
            @foreach ($turnos as $t)
                <option value="{{ $t->id }}"
                        @if(isset($turno) and ($turno->id === $t->id)) selected @endif>{{$t->codigo}}
                    {{--({{$t->descripcion}})--}}
                </option>
            @endforeach
        </select>
        @if($errors->has('turno'))
            <span class="help-block">{{$errors->first('turno')}}</span>
        @endif
    </div>
</div>


