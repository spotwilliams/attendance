<table class="table table-responsive" id="baseModels-table">
    <thead>
        <th>Nombre</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($baseModels as $baseModel)
        <tr>
            <td>{!! $baseModel->nombre !!}</td>
            <td>
                {!! Form::open(['route' => ['baseModels.destroy', $baseModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('baseModels.show', [$baseModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('baseModels.edit', [$baseModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>