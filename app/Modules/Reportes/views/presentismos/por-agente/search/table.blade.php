<table class="table table-hover">
    <thead>
    <th></th>
    <th>Personal</th>
    <th>CUIT</th>
    <th>Base</th>
    <th></th>
    </thead>
    <tbody>
    @foreach ($agentes as $agente)
        <tr>
            <td><a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover" title="Ver datos"
                   data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank"
                   class="label label-success"><i class="fa fa-eye"></i></a></td>
            <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
            <td>{{$agente->cuit}}</td>
            <td>@if(isset($agente->operativo))
                    {{$agente->operativo->base->nombre}}
                @endif
            </td>
            <td>
                @if($agente->contrato)
                    <form action="{{ route('reportesPresentismoIndividualReportePresentismos') }}" method="POST">@csrf
                    <input type="hidden" name="agente" value="{{$agente->id}}">
{{--                    {!! \Cat\Helpers\HtmlCustoms::getSelectByTipoContrato($agente->contrato->tipoContrato, true, 'selectpicker', '200px') !!}--}}
                    <button type="submit" class="btn btn-primary">Ver licencias</button>

                    </form>
                @else
                    <p class="help-block">El agente no tiene datos laborales u operativos para poder trabajar</p>
                @endif

            </td>
        </tr>
    @endforeach

    </tbody>
</table>
