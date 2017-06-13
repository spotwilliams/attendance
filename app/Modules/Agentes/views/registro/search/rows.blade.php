@forelse ($agentes as $agente)
    <tr>
        <td>{{$agente->id}}</td>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
        <td>{{$agente->cuit}}</td>
    </tr>

@endforeach
<nav>{{ $agentes->appends(Request::except('page'))->links() }}</nav>

