<?php
$estado_estudiosToDraw = [
    'COMPLETO',
    'INCOMPLETO',
    'EN CURSO',
];

/** @var \Illuminate\Support\Collection $estado_estudios */
$aSelected   = (isset($estado_estudios) ? ($estado_estudios->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('estado_estudios')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('estado_estudios'))
            <span class="help-block">{{$errors->first('estado_estudios')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-estado_estudios">Marcar todas</a>
            <a class="btn btn-default none-estado_estudios">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseestado_estudios"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapseestado_estudios">

            @foreach ($estado_estudiosToDraw as $key => $estado_estudio)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="estado_estudio-option"
                           value="{{$estado_estudio}}"
                           id="chk_estado_estudio_{{$key}}"
                           name="estado_estudios[]"
                           @if(in_array($estado_estudio,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_estado_estudio_{{$key}}">
                        {{$estado_estudio}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-estado_estudios').on('click', function () {
                $('.estado_estudio-option').prop('checked', true);
            })
            $('.none-estado_estudios').on('click', function () {
                $('.estado_estudio-option').prop('checked', false);
            })
        })
    </script>
@append
