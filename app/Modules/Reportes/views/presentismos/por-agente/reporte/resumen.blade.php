<?php
$resumen = $agente->presentismos->groupBy(function ($presentismo, $key) {
    return $presentismo->tipoPresentismo->codigo . '@' . $presentismo->tipoPresentismo->color;
});
?>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resumen</h3>

        <div class="box-tools pull-right">
            {{--<a href="{{route('reportesPresentismoIndividualIndex')}}" class="btn btn-default">Atr&aacute;s</a>--}}
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-group list-group-unbordered">
                    @if($resumen->isEmpty())
                        <li class="list-group-item">
                            <b>No se encontraron licencias</b>
                        </li>
                    @else
                        @foreach($resumen as $tipo => $dias)
                            <?php
                            $tipo = explode('@', $tipo);
                            ?>
                                <li class="list-group-item">
                                    <span class="label" style="background: {{$tipo[1]}}">{{$tipo[0]}}</span><a class="pull-right"><span class="description-text">{{count($dias)}}</span></a>
                                </li>

                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

</div>
