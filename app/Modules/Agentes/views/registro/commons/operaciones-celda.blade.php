<td>
    {{ Form::open(['route' => 'presentismoPorAgenteRegistro', 'method' => 'POST'])}}

    <a href="{{route('agentesEditPersonales', ['id' => $agente->id])}}"
       class="btn btn-primary"
       data-toggle="tooltip" data-placement="top" title="Editar"
    >
        <i class="fa fa-edit"></i>
    </a>
    {{--<a href="{{route('agentesDelete', ['id' => $agente->id])}}"--}}
    {{--class="btn btn-danger"--}}
    {{--data-toggle="tooltip" data-placement="top" title="Borrar"--}}
    {{-->--}}
    {{--<i class="fa fa-trash-o"></i>--}}
    {{--</a>--}}
    <a href="{{route('agentesShow', ['id' => $agente->id])}}"
       class="btn btn-success"
       data-toggle="tooltip" data-placement="top" title="Ver"
    >
        <i class="fa fa-eye"></i>
    </a>
    <button type="submit" class="btn btn-info"
            data-toggle="tooltip" data-placement="top" title="Cargar presentismo"
    ><i class="fa fa-calendar"></i></button>
    <input type="hidden" name="desde" value="{{$desdePre}}" >
    <input type="hidden" name="hasta" value="{{$hastaPre}}" >
    <input type="hidden" name="agente" value="{{$agente->id}}">
    {{ Form::close() }}
</td>