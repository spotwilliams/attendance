<div class="table-responsive">

    <table class="resultados">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>CUIT</th>
            <th>Monto facturado</th>
            <th>D&iacute;as injustificados</th>
            <th>Nro. Factura</th>
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
                <td>
                    @if($agente->detalle->monto === $agente->detalle->montoContrato)
                        <span class="label label-default">
                    @else
                                <span class="label label-warning">
                    @endif
                                    $ {{$agente->detalle->monto}}
                        </span>
                </td>
                <td>
                    @if($agente->detalle->diasADescontar  == 0)
                        <span class="label label-default">
                    @else
                                <span class="label label-warning">
                    @endif
                                    {{$agente->detalle->diasADescontar}}
                                </span>
                </td>
                <td>
                    <label>{{$agente->facturas->first()->nro_factura}}</label>
                </td>
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
