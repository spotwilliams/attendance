<table class="table table-responsive" id="agentes-table">
    <thead>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Dni</th>
        <th>Fecha Nacimiento</th>
        <th>Cuit</th>
        <th>Id Base</th>
        <th>Id Area</th>
        <th>Id Domicilio</th>
        <th>Id Contrato</th>
        <th>Id Dias Disponibles</th>
        <th>Id Estudio</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($agentes as $agente)
        <tr>
            <td>{!! $agente->nombre !!}</td>
            <td>{!! $agente->apellido !!}</td>
            <td>{!! $agente->dni !!}</td>
            <td>{!! $agente->fecha_nacimiento !!}</td>
            <td>{!! $agente->cuit !!}</td>
            <td>{!! $agente->id_base !!}</td>
            <td>{!! $agente->id_area !!}</td>
            <td>{!! $agente->id_domicilio !!}</td>
            <td>{!! $agente->id_contrato !!}</td>
            <td>{!! $agente->id_dias_disponibles !!}</td>
            <td>{!! $agente->id_estudio !!}</td>
            <td>
                {!! Form::open(['route' => ['agentes.destroy', $agente->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('agentes.show', [$agente->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('agentes.edit', [$agente->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>