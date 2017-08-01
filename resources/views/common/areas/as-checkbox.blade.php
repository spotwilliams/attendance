<?php
$areasToDraw = \Cat\Repositories\AreaRepository::getAll();
/** @var \Illuminate\Support\Collection $areas */
$aSelected   = (isset($areas) ? ($areas->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('areas')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('areas'))
            <span class="help-block">{{$errors->first('areas')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-areas">Marcar todas</a>
            <a class="btn btn-default none-areas">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseAreas"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapseAreas">

            @foreach ($areasToDraw as $area)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="area-option"
                           value="{{$area->id}}"
                           id="chk_area_{{$area->id}}"
                           name="areas[]"
                           @if(in_array($area->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_area_{{$area->id}}">
                        {{$area->nombre}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-areas').on('click', function () {
                $('.area-option').prop('checked', true);
            })
            $('.none-areas').on('click', function () {
                $('.area-option').prop('checked', false);
            })
        })
    </script>
@append