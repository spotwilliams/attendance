<?php
$iibbsToDraw = [
    'Regimen simplificado'  => 'R&eacute;gimen simplificado',
    'Convenio multilareral' => 'Convenio multilareral',
    'Regimen general'       => 'R&eacute;gimen general'
];

/** @var \Illuminate\Support\Collection $iibbs */
$aSelected   = (isset($iibbs) ? ($iibbs->toArray()) : []);
$col_label   = (isset($labelCol) ? $labelCol : 3);
$col_content = (isset($contentCol) ? $contentCol : 9);
?>

<div class="form-group @if($errors->has('iibbs')) has-error @endif">
    <label class="col-sm-{{$col_label}} col-xs-{{$col_label}} control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/las &aacute;reas
        @endif
    </label>

    <div class="col-sm-{{$col_content}} col-xs-{{$col_content}}">
        @if($errors->has('iibbs'))
            <span class="help-block">{{$errors->first('iibbs')}}</span>
        @endif

        <div class="box-tools col-md-12 pull-left">
            <a class="btn btn-default all-iibbs">Marcar todas</a>
            <a class="btn btn-default none-iibbs">Desmarcar todas</a>
            <button
                    class="btn btn-box-tool"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseiibbs"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                <i class="fa fa-minus"></i>/ <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="collapse" id="collapseiibbs">

            @foreach ($iibbsToDraw as $key => $iibb)
                <div class="checkbox checkbox-info checkbox-circle col-md-4 col-xs-6 col-lg-4">
                    <input type="checkbox"
                           class="iibb-option"
                           value="{{$key}}"
                           id="chk_iibb_{{$key}}"
                           name="iibbs[]"
                           @if(in_array($key, $aSelected))
                           checked
                            @endif
                    >
                    <label for="chk_iibb_{{$key}}">
                        {{$iibb}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (event, element) {
            $('.all-iibbs').on('click', function () {
                $('.iibb-option').prop('checked', true);
            })
            $('.none-iibbs').on('click', function () {
                $('.iibb-option').prop('checked', false);
            })
        })
    </script>
@append