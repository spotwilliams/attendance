<div class="table-responsive">

    <table class="resultados">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>CUIT</th>
            <th>Monto a facturar</th>
            <th>D&iacute;as registrados</th>
            <th>Justificados</th>
            <th>No justificados</th>
        </tr>
        </thead>
        <tbody>
        @foreach(isset($agentes) ?$agentes: [] as $agente)
            <tr>
                <td>
                    <a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover" title="Ver datos"
                       data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank"
                       class="label label-success"><i class="fa fa-eye"></i></a>
                </td>
                <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
                <td>{{$agente->cuit}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>

<div class="text-center">
    @if(isset($agentes) and !$agentes->isEmpty())
        {{$agentes->links()}}
    @endif
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
