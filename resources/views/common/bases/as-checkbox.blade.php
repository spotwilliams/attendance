<?php
$basesToDraw = \Cat\Repositories\BaseRepository::getAll();
/** @var \Illuminate\Support\Collection $bases */
$aSelected   = (isset($bases) ? ($bases->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('bases')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('bases'))
            <span class="help-block">{{$errors->first('bases')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-bases">Marcar todas</a>
            <a class="btn btn-default none-bases">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapsebases"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapsebases">

            @foreach ($basesToDraw as $base)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="base-option"
                           value="{{$base->id}}"
                           id="chk_base_{{$base->id}}"
                           name="bases[]"
                           @if(in_array($base->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_base_{{$base->id}}">
                        {{$base->nombre}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-bases').on('click', function () {
                $('.base-option').prop('checked', true);
            })
            $('.none-bases').on('click', function () {
                $('.base-option').prop('checked', false);
            })
        })
    </script>
@append