<?php
$modelToDraw = \Cat\Repositories\TurnosRepository::getAll();

/** @var \Illuminate\Support\Collection $turnos */
$mSelected   = (isset($turnos) ? ($turnos->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content   = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('turnos')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/los turnos
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('turnos'))
            <span class="help-block">{{$errors->first('turnos')}}</span>
        @endif

        <div class="col-md-12 pull-left">
            <a class="btn btn-default all-turnos control-label">Marcar todos</a>
            <a class="btn btn-default none-turnos control-label">Desmarcar todos</a>
            <a
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseTurnos"
                    aria-expanded="true"
                    aria-controls="collapseTurnos">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </a>
        </div>

        <div class="collapse" id="collapseTurnos">

            @foreach ($modelToDraw as $turno)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="turno-option"
                           value="{{$turno->id}}"
                           id="chk_turno_{{$turno->id}}"
                           name="turnos[]"
                           @if(in_array($turno->id,$mSelected))
                           checked
                            @endif
                    >
                    <label for="chk_turno_{{$turno->id}}">
                        {{$turno->codigo}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-turnos').on('click', function () {
                $('.turno-option').prop('checked', true);
            })
            $('.none-turnos').on('click', function () {
                $('.turno-option').prop('checked', false);
            })
        })
    </script>
@append