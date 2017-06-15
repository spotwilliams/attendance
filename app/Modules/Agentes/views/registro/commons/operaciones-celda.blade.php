<td>
    <a href="{{route('agentesEditPersonales', ['id' => $agente->id])}}"
       class="btn btn-primary"
       data-toggle="tooltip" data-placement="top" title="Editar"
    >
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{route('agentesDelete', ['id' => $agente->id])}}"
       class="btn btn-danger"
       data-toggle="tooltip" data-placement="top" title="Borrar"
    >
        <i class="fa fa-trash-o"></i>
    </a>
    <a href="{{route('agentesShow', ['id' => $agente->id])}}"
       class="btn btn-success"
       data-toggle="tooltip" data-placement="top" title="Ver"
    >
        <i class="fa fa-eye"></i>
    </a>

</td>