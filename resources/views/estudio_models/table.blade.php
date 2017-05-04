<table class="table table-responsive" id="estudioModels-table">
    <thead>
        <th>Institucion</th>
        <th>Carrera</th>
        <th>Estado</th>
        <th>Comentario</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($estudioModels as $estudioModel)
        <tr>
            <td>{!! $estudioModel->institucion !!}</td>
            <td>{!! $estudioModel->carrera !!}</td>
            <td>{!! $estudioModel->estado !!}</td>
            <td>{!! $estudioModel->comentario !!}</td>
            <td>
                {!! Form::open(['route' => ['estudioModels.destroy', $estudioModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('estudioModels.show', [$estudioModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('estudioModels.edit', [$estudioModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>