<table class="table table-responsive" id="jornadaLaborables-table">
    <thead>
        <th>Fecha</th>
        <th>Id Periodo</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($jornadaLaborables as $jornadaLaborable)
        <tr>
            <td>{!! $jornadaLaborable->fecha !!}</td>
            <td>{!! $jornadaLaborable->id_periodo !!}</td>
            <td>
                {!! Form::open(['route' => ['jornadaLaborables.destroy', $jornadaLaborable->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jornadaLaborables.show', [$jornadaLaborable->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('jornadaLaborables.edit', [$jornadaLaborable->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>