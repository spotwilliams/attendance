<?php
/** @var \Illuminate\Support\Collection $haberes */
if (!isset($data)) {
    $haberes = new \Illuminate\Support\Collection();

} else {
    $haberes = new \Illuminate\Support\Collection($data->items());
}
?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resultados obtenidos</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12 col-xs-12 table-responsive">
            <table>
                <tr>
                    <th>Personal</th>
                    <th>CUIT</th>
                    <th>Base</th>
                    <th>Turno</th>
                    <th>Monto</th>
                </tr>
                @if(!$haberes->isEmpty())
                    @foreach($haberes as $h)
                        <tr>
                            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'apellido'])}}
                                , {{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'nombre'])}}
                            </td>
                            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'cuit'])}}</td>
                            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['base', 'nombre'])}}</td>
                            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['turno', 'codigo'])}}</td>
                            <td>$ {{$h->monto_facturado}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                    <td colspan="5">No se encontraron registros para la selecci&oacute;n, verifique que se hayan cerrado los periodos seleccionados</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <div class="box-footer text-center">
        @if(isset($data))
            {{$links}}
        @endif
    </div>
</div>
