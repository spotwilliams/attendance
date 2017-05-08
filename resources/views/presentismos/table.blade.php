<table class="table table-responsive" id="presentismos-table">
    <thead>
        <th>Id Agente</th>
        <th>Id Jornada</th>
        <th>Id Tipo Presentismo</th>
        <th>Id Padre</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($presentismos as $presentismo)
        <tr>
            <td>{!! $presentismo->id_agente !!}</td>
            <td>{!! $presentismo->id_jornada !!}</td>
            <td>{!! $presentismo->id_tipo_presentismo !!}</td>
            <td>{!! $presentismo->id_padre !!}</td>
            <td>
                {!! Form::open(['route' => ['presentismos.destroy', $presentismo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('presentismos.show', [$presentismo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('presentismos.edit', [$presentismo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>