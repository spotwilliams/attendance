<table class="table table-responsive" id="contratos-table">
    <thead>
        <th>Tipo Contrato</th>
        <th>Fecha Firma</th>
        <th>Fecha Comienzo</th>
        <th>Id Estado Contrato</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($contratos as $contratos)
        <tr>
            <td>{!! $contratos->tipo_contrato !!}</td>
            <td>{!! $contratos->fecha_firma !!}</td>
            <td>{!! $contratos->fecha_comienzo !!}</td>
            <td>{!! $contratos->id_estado_contrato !!}</td>
            <td>
                {!! Form::open(['route' => ['contratos.destroy', $contratos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('contratos.show', [$contratos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('contratos.edit', [$contratos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>