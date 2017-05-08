<table class="table table-responsive" id="periodos-table">
    <thead>
        <th>Fecha Comienzo</th>
        <th>Fecha Fin</th>
        <th>Cant Dias</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($periodos as $periodo)
        <tr>
            <td>{!! $periodo->fecha_comienzo !!}</td>
            <td>{!! $periodo->fecha_fin !!}</td>
            <td>{!! $periodo->cant_dias !!}</td>
            <td>
                {!! Form::open(['route' => ['periodos.destroy', $periodo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('periodos.show', [$periodo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('periodos.edit', [$periodo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>