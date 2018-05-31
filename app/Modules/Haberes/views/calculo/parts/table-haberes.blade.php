<div class="table-responsive">

    <table class="resultados">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>CUIT</th>
            <th>Monto a facturar</th>
            <th>D&iacute;as injustificados</th>
            <th>Nro. Factura</th>
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
                        {{--Necesario por si ocurren errores de validacion, y se tiene que recargar la vista--}}
                        <input type="hidden" name="agentes[]" value="{{$agente->id}}">

                        <?php
                        $oldFacts = old('facturas') ?: [];

                        ?>
                        <input type="checkbox" id="check_agente_{{$agente->id}}" class="agente-option"
                               value="{{$agente->id}}" @if(array_key_exists($agente->id, $oldFacts)) checked @endif>
                        <label for="check_agente_{{$agente->id}}">
                            {{$agente->apellido}}, {{$agente->nombre}}
                        </label>
                    </div>
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

                    <input type="text" name="facturas[{{$agente->id}}]"

                           @if(!array_key_exists($agente->id, $oldFacts)) disabled class=" form-control disabled"
                           @else class="form-control" value="{{$oldFacts[$agente->id]}}"  @endif
                    >
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
