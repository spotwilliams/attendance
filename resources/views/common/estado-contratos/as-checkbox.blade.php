<?php
$estadoContratosToDraw = \Cat\Repositories\EstadoContratoRepository::getAll();
/** @var \Illuminate\Support\Collection $estadoContratos */
$aSelected   = (isset($estadoContratos) ? ($estadoContratos->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('estadoContratos')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('estadoContratos'))
            <span class="help-block">{{$errors->first('estadoContratos')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-estadoContratos">Marcar todas</a>
            <a class="btn btn-default none-estadoContratos">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseestadoContratos"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapseestadoContratos">

            @foreach ($estadoContratosToDraw as $estadoContrato)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="estadoContrato-option"
                           value="{{$estadoContrato->id}}"
                           id="chk_estadoContrato_{{$estadoContrato->id}}"
                           name="estadoContratos[]"
                           @if(in_array($estadoContrato->id,$aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_estadoContrato_{{$estadoContrato->id}}">
                        {{$estadoContrato->descripcion}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-estadoContratos').on('click', function () {
                $('.estadoContrato-option').prop('checked', true);
            })
            $('.none-estadoContratos').on('click', function () {
                $('.estadoContrato-option').prop('checked', false);
            })
        })
    </script>
@append