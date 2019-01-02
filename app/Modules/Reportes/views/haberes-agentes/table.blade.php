<?php
/** @var \Illuminate\Support\Collection $agentes */
if (!isset($data)) {
    $agentes = new \Illuminate\Support\Collection();
    $count = 0;
} else {
    $agentes = new \Illuminate\Support\Collection($data->items());
    $count = $data->total();
}
if(!isset($periodosColection)) {
    $periodosColection = new \Illuminate\Support\Collection();
}
?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Se econtraron <label class="label label-info">{{$count}}</label> agentes</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12 col-xs-12 table-responsive">
            <table>
                <thead>

                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">Personal</th>
                    <th rowspan="2">CUIT</th>
                    <th rowspan="2">Base</th>
                    <th rowspan="2">Turno</th>
                    @if($periodosColection->isEmpty())


                        <th colspan="3">Periodo</th>
                    @else
                        @foreach($periodosColection as $p)
                            <?php
                            $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $p->fecha_fin);
                            $mesFacturacion->addMonth(1);
                            ?>
                            <th colspan="3">{{trans('month.'.$mesFacturacion->format('m'))}}
                                '{{$mesFacturacion->format('y')}}</th>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    @if($periodosColection->isEmpty())
                        <th>Monto</th>
                        <th>Notificado</th>
                        <th>Facturado</th>
                    @else
                        @foreach($periodosColection as $p)
                            <th>Monto</th>
                            <th>Notificado</th>
                            <th>Facturado</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                @foreach($agentes as $agente)
                    <tr>
                        <td><a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover"
                               title="Ver datos" data-content="Abre la ficha del agente en otra pesta&ntilde;a"
                               target="_blank" class="label label-success"><i class="fa fa-eye"></i></a></td>

                        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, [ 'apellido'])}}
                            , {{\Cat\Helpers\ModelCreator::getDataFromModel($agente, [ 'nombre'])}}
                        </td>
                        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, [ 'cuit'])}}</td>
                        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre'])}}</td>
                        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'codigo'])}}</td>
                        <?php
                        $facturas = $agente->facturas->keyBy('id_periodo');
                        $notificaciones = $agente->notificaciones->keyBy('id_periodo');
                        $haberes = $agente->haberes->keyBy('id_periodo');
                        $service = new \Cat\Modules\Haberes\Services\Calculo\Calculador();
                        ?>
                        @foreach($periodosColection as $p)
                            <?php
                            if ($haberes->get($p->id)) {
                                $monto = $haberes->get($p->id)->monto_facturado;
                            } else {
                                $monto = $service->reset($agente, $p)->execute()->monto;
                            }

                            if ($facturas->get($p->id)) {
                                $facturado = '<label class="label label-success">Si</label>';
                            } else {
                                $facturado = '<label class="label label-warning">No</label>';

                            }
                            if ($notificaciones->get($p->id)) {
                                $notificado = '<label class="label label-success">Si</label>';

                            } else {
                                $notificado = '<label class="label label-warning">No</label>';

                            }


                            ?>
                            <th><label class="label label-default">$ {{round( $monto, 2)}}</label></th>
                            <th>{!! $notificado !!}</th>
                            <th>{!! $facturado !!}</th>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="box-footer text-center">
        @if(isset($data))
            {{$links}}
        @endif
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        })
    </script>
@append