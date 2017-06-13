@forelse ($agentes as $agente)
    <tr>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
        <td>{{$agente->dni}}</td>
        <td>{{$agente->cuit}}</td>
        <td>{{$agente->operativo->base->nombre}}</td>
    </tr>
@endforeach
