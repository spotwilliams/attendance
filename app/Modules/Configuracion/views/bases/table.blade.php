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
                {!! Form::open(['route' => ['configuracion.base.destroy', $baseModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('configuracion.base.show', [$baseModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('configuracion.base.edit', [$baseModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>