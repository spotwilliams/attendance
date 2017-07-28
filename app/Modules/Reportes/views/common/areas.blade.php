<?php
$areasToDraw = \Cat\Repositories\AreaRepository::getAll();
/** @var \Illuminate\Support\Collection $areas */
$aSelected = (isset($areas) ? ($areas->toArray()) : []);
?>

<div class="row">
    <div class="box-tools pull-left">
        <a class="btn btn-default all-areas">
            <span class="label label-info">Marcar Todas</span>
        </a>
        <a class="btn btn-default none-areas">
            <span class="label label-info">Desmarcar todas</span>
        </a>
        <button
                class="btn btn-box-tool"
                type="button"
                data-toggle="collapse"
                data-target="#collapseExample"
                aria-expanded="true"
                aria-controls="collapseExample">
            <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
        </button>
    </div>
</div>

<div class="collapse" id="collapseExample">

    @foreach ($areasToDraw as $area)
        <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
            <input type="checkbox"
                   class="area-option"
                   value="{{$area->id}}"
                   id="chk_{{$area->id}}"
                   name="areas[]"
                   @if(in_array($area->id,$aSelected))
                   checked
                    @endif
            >
            <label for="chk_{{$area->id}}">
                {{$area->nombre}}
            </label>
        </div>
    @endforeach
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