<table class="table table-responsive" id="presentismoModels-table">
    <thead>
        <th>Id Agente</th>
        <th>Id Jornada</th>
        <th>Id Tipo Presentismo</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($presentismoModels as $presentismoModel)
        <tr>
            <td>{!! $presentismoModel->id_agente !!}</td>
            <td>{!! $presentismoModel->id_jornada !!}</td>
            <td>{!! $presentismoModel->id_tipo_presentismo !!}</td>
            <td>
                {!! Form::open(['route' => ['presentismoModels.destroy', $presentismoModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('presentismoModels.show', [$presentismoModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('presentismoModels.edit', [$presentismoModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>