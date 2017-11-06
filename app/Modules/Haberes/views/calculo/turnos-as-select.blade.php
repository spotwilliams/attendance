<?php


$multiple = (!isset($multiple) ? '' : $multiple);
$name     = ($multiple !== '') ? 'turno[]' : 'turno';
if(!isset($turno)) {
    $turno = [];
}
if (!$multiple or !isset($turno) or !is_array($turno)) {
    $turno = [$turno];
}
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
        <select class="form-control" {{$multiple}} name="{{$name}}" data-live-search="true">
            @if(!$multiple)
                <option value="-1">...</option>
            @endif
            @foreach (\Cat\Repositories\TurnosRepository::getOnlyForLocacion()->get() as $t)
                <option value="{{ $t->id }}"
                        @if(isset($turno) and in_array($t->id, $turno)) selected @endif>{{$t->codigo}}
                </option>
            @endforeach
        </select>
        @if($errors->has('turno'))
            <span class="help-block">{{$errors->first('turno')}}</span>
        @endif
    </div>
</div>


