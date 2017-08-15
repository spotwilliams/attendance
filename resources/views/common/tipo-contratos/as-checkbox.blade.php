<?php
$tipoContratosToDraw = \Cat\Repositories\TipoContratoRepository::getAll();
/** @var \Illuminate\Support\Collection $tipoContratos */
$aSelected   = (isset($tipoContratos) ? ($tipoContratos->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('tipoContratos')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('tipoContratos'))
            <span class="help-block">{{$errors->first('tipoContratos')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-tipoContratos">Marcar todas</a>
            <a class="btn btn-default none-tipoContratos">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapsetipoContratos"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapsetipoContratos">

            @foreach ($tipoContratosToDraw as $tipoContrato)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="tipoContrato-option"
                           value="{{$tipoContrato->id}}"
                           id="chk_tipoContrato_{{$tipoContrato->id}}"
                           name="tipoContratos[]"
                           @if(in_array($tipoContrato->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_tipoContrato_{{$tipoContrato->id}}">
                        {{$tipoContrato->descripcion}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-tipoContratos').on('click', function () {
                $('.tipoContrato-option').prop('checked', true);
            })
            $('.none-tipoContratos').on('click', function () {
                $('.tipoContrato-option').prop('checked', false);
            })
        })
    </script>
@append