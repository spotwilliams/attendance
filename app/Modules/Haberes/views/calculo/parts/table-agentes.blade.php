<div class="table-responsive">

    <table class="resultados dataTable no-footer">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>CUIT</th>
            <th>Base</th>
            <th>Turno</th>
            <th>Monto a facturar</th>
            <th>Faltas</th>
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
                <td>
                    <div class="checkbox checkbox-info checkbox-circle">
                        <input type="checkbox" id="check_agente_{{$agente->id}}" class="agente-option" name="agentes[]"
                               value="{{$agente->id}}">
                        <label for="check_agente_{{$agente->id}}">
                            {{$agente->apellido}}, {{$agente->nombre}}
                        </label>
                    </div>
                </td>
                <td>{{$agente->cuit}}</td>
                <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre'])}}</td>
                <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'codigo'])}}</td>
                <td>
                    @if($agente->detalle->monto == $agente->detalle->montoContrato)
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
            </tr>
        @endforeach
        </tbody>
    </table>


</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
            $('table.resultados').dataTable({
                searching: false,
                bInfo: false,
                paging: false,
                ordering: false,
            });

        })
    </script>
@append
