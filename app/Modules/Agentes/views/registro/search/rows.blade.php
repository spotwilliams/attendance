@forelse ($agentes as $agente)
    <tr>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
        <td>{{$agente->cuit}}</td>
        <td>@if(isset($agente->operativo))
                {{$agente->operativo->base->nombre}}
            @endif
        </td>
        @include('Agentes::registro.commons.operaciones-celda')
    </tr>
    @endforeach
