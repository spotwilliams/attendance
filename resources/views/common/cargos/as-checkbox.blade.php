<?php
$cargosToDraw = \Cat\Repositories\CargoRepository::getAll();
/** @var \Illuminate\Support\Collection $cargos */
$aSelected   = (isset($cargos) ? ($cargos->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('cargos')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('cargos'))
            <span class="help-block">{{$errors->first('cargos')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-cargos">Marcar todos</a>
            <a class="btn btn-default none-cargos">Desmarcar todos</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapsecargos"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapsecargos">

            @foreach ($cargosToDraw as $cargo)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="cargo-option"
                           value="{{$cargo->id}}"
                           id="chk_cargo_{{$cargo->id}}"
                           name="cargos[]"
                           @if(in_array($cargo->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_cargo_{{$cargo->id}}">
                        {{$cargo->nombre}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-cargos').on('click', function () {
                $('.cargo-option').prop('checked', true);
            })
            $('.none-cargos').on('click', function () {
                $('.cargo-option').prop('checked', false);
            })
        })
    </script>
@append