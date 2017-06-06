<?php $bases = \Cat\Models\Base::all(); ?>

<div class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-2 col-xs-2 control-label">{{$label}}</label>
        <div class="col-sm-6 col-xs-6">
            <select class="form-control" id="base-select-sin-btn" name="base">

                @foreach ($bases as $base)
                    <option value="{{ $base->id }}" {{($baseSeleccionada == $base->id) ? 'selected': ''}}>{!! $base->nombre !!}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


