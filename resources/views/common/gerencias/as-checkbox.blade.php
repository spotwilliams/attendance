<?php
$modelToDraw = \Cat\Repositories\GerenciaRepository::getAll();

/** @var \Illuminate\Support\Collection $gerencias */
$mSelected   = (isset($gerencias) ? ($gerencias->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content   = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('gerencias')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione la/las gerencias
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('gerencias'))
            <span class="help-block">{{$errors->first('gerencias')}}</span>
        @endif

        <div class="col-md-12 pull-left">
            <a class="btn btn-default all-gerencias control-label">Marcar todos</a>
            <a class="btn btn-default none-gerencias control-label">Desmarcar todos</a>
            <a
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseGerencias"
                    aria-expanded="true"
                    aria-controls="collapseGerencias">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </a>
        </div>

        <div class="collapse" id="collapseGerencias">

            @foreach ($modelToDraw as $gere)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="gerencia-option"
                           value="{{$gere->id}}"
                           id="chk_gerencia_{{$gere->id}}"
                           name="gerencias[]"
                           @if(in_array($gere->id,$mSelected))
                           checked
                            @endif
                    >
                    <label for="chk_gerencia_{{$gere->id}}">
                        {{$gere->nombre}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-gerencias').on('click', function () {
                $('.gerencia-option').prop('checked', true);
            })
            $('.none-gerencias').on('click', function () {
                $('.gerencia-option').prop('checked', false);
            })
        })
    </script>
@append