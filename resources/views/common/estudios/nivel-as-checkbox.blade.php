<?php
$nivel_estudiosToDraw = [
    'SECUNDARIO',
    'TERCIARIO',
    'UNIVERSITARIO',
    'POSGRADO',
    'MASTER',
    'DOCTORADO',
    'OTRO',
];

/** @var \Illuminate\Support\Collection $nivel_estudios */
$aSelected   = (isset($nivel_estudios) ? ($nivel_estudios->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('nivel_estudios')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('nivel_estudios'))
            <span class="help-block">{{$errors->first('nivel_estudios')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-nivel_estudios">Marcar todas</a>
            <a class="btn btn-default none-nivel_estudios">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapsenivel_estudios"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapsenivel_estudios">

            @foreach ($nivel_estudiosToDraw as $key => $nivel_estudio)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="nivel_estudio-option"
                           value="{{$nivel_estudio}}"
                           id="chk_nivel_estudio_{{$key}}"
                           name="nivel_estudios[]"
                           @if(in_array($nivel_estudio,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_nivel_estudio_{{$key}}">
                        {{$nivel_estudio}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-nivel_estudios').on('click', function () {
                $('.nivel_estudio-option').prop('checked', true);
            })
            $('.none-nivel_estudios').on('click', function () {
                $('.nivel_estudio-option').prop('checked', false);
            })
        })
    </script>
@append
