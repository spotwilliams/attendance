<?php
$resumen = $agentes->get(0)->presentismos->groupBy(function ($presentismo, $key) {
    return $presentismo->tipoPresentismo->codigo . '@' . $presentismo->tipoPresentismo->color;
});
?>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resumen</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">

            @foreach($resumen as $tipo => $dias)
                <div class="col-sm-3 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header">
                            <?php
                            $tipo = explode('@', $tipo);
                            ?>
                            <span class="label" style="background: {{$tipo[1]}}">{{$tipo[0]}}</span>
                        </h5>
                        <span class="description-text">{{count($dias)}}</span>
                    </div>
                    <!-- /.description-block -->
                </div>

            @endforeach
        </div>
    </div>

</div>
