<table class="table table-hover">

    <thead>
    <tr>
        <th></th>
        <th>Personal</th>
        <th>CUIT</th>
        <th>Tipo de contrato</th>
        <th>Estado</th>
        <th>Gerencia/Subgerencia</th>
        <th>&Aacute;rea</th>
        <th>Turno</th>
    </tr>
    </thead>
    <tbody>
    @foreach($area->operativos as $agente)
        <tr>
            <td><a href="{{route('agentesEditOperativos', ['id' => $agente->agente->id])}}" data-toggle="popover"
                   title="Editar datos operativos"
                   data-content="Abre la ficha de edici&oacute;n del agente en otra pesta&ntilde;a" target="_blank"
                   class="label label-success"><i class="fa fa-eye"></i></a>
            </td>
            <td>{{$agente->agente->apellido}}, {{$agente->agente->nombre}}</td>
            <td>{{$agente->agente->cuit}}</td>
            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['agente','contrato','tipoContrato','descripcion'])}}</td>
            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['agente','contrato','estadoContrato', 'descripcion'])}}</td>
            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['agente','operativo','gerencia','nombre'])}}</td>
            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['agente','operativo','area','nombre'])}}</td>
            <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['agente','operativo','turno', 'codigo'])}}</td>
        </tr>
    @endforeach
    </tbody>

</table>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').dataTable({
                paging: true,
                ordering: false,
                info: false,
                searching: false,
                dom: 'rtip',
                language : {
                    sEmptyTable: 'Base sin agentes asignados'
                }
            });
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
            });
        })
    </script>
@append