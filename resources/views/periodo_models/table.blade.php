<table class="table table-responsive" id="periodoModels-table">
    <thead>
        <th>Fecha Comienzo</th>
        <th>Fecha Fin</th>
        <th>Cant Dias</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($periodoModels as $periodoModel)
        <tr>
            <td>{!! $periodoModel->fecha_comienzo !!}</td>
            <td>{!! $periodoModel->fecha_fin !!}</td>
            <td>{!! $periodoModel->cant_dias !!}</td>
            <td>
                {!! Form::open(['route' => ['periodoModels.destroy', $periodoModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('periodoModels.show', [$periodoModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('periodoModels.edit', [$periodoModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>