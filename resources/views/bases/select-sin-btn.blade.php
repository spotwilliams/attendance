<?php $bases = \Cat\Models\Base::all(); ?>

<label class="col-sm-3 col-xs-3 control-label">{{$label}}</label>
<div class="col-sm-9 col-xs-9">
    <select class="form-control" id="base-select-sin-btn" name="base" data-live-search="true">
        <option value="-1">...</option>
        @foreach ($bases as $base)
            <option value="{{ $base->id }}" {{($baseSeleccionada == $base->id) ? 'selected': ''}}>{!! $base->nombre !!}</option>
        @endforeach
    </select>
</div>

