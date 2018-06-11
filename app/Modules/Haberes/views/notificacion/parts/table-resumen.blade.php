<div class="table-responsive">

    <table class="resultados">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>CUIT</th>
            <th>Base</th>
            <th>Turno</th>
        </tr>
        </thead>
        <tbody>
        @foreach(isset($agentes) ? $agentes: [] as $agente)
            <tr>
                <td>
                    <a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover" title="Ver datos"
                       data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank"
                       class="label label-success"><i class="fa fa-eye"></i></a>
                </td>
                <td>
                    {{$agente->apellido}}, {{$agente->nombre}}
                </td>
                <td>{{$agente->cuit}}</td>
                <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre'])}}</td>
                <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'codigo'])}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>


</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table.resultados').dataTable({
                searching: false,
                bInfo: false,
                paging: false,
                ordering: false,
            });

            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        })
    </script>
@append
