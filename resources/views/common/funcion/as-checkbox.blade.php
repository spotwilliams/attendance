<?php
$funcionToDraw = \Cat\Repositories\FuncionRepository::getAll();
/** @var \Illuminate\Support\Collection $funcion */
$aSelected   = (isset($funcion) ? ($funcion->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('funcion')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione la/las funciones
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('funcion'))
            <span class="help-block">{{$errors->first('funcion')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-funcion">Marcar todas</a>
            <a class="btn btn-default none-funcion">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseFuncion"
                    aria-expanded="true"
                    aria-controls="collapseFuncion">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapseFuncion">

            @foreach ($funcionToDraw as $funcion)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="funcion-option"
                           value="{{$funcion->id}}"
                           id="chk_funcion_{{$funcion->id}}"
                           name="funcion[]"
                           @if(in_array($funcion->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_funcion_{{$funcion->id}}">
                        {{$funcion->nombre}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-funcion').on('click', function () {
                $('.funcion-option').prop('checked', true);
            })
            $('.none-funcion').on('click', function () {
                $('.funcion-option').prop('checked', false);
            })
        })
    </script>
@append