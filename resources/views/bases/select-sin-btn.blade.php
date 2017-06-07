<?php $bases = \Cat\Models\Base::all(); ?>

<div class="form-group">
    <label class="col-sm-3 col-xs-3 control-label">{{$label}}</label>
    <div class="col-sm-8 col-xs-8">
        <select class="form-control" id="base-select-sin-btn" name="base">

            @foreach ($bases as $base)
                <option value="{{ $base->id }}" {{($baseSeleccionada == $base->id) ? 'selected': ''}}>{!! $base->nombre !!}</option>
            @endforeach
        </select>
    </div>
</div>


