<table class="table table-responsive" id="areasModels-table">
    <thead>
        <th>Direccion</th>
        <th>Gerencia</th>
        <th>Subgerencia</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($areasModels as $areasModel)
        <tr>
            <td>{!! $areasModel->direccion !!}</td>
            <td>{!! $areasModel->gerencia !!}</td>
            <td>{!! $areasModel->subgerencia !!}</td>
            <td>
                {!! Form::open(['route' => ['areasModels.destroy', $areasModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('areasModels.show', [$areasModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('areasModels.edit', [$areasModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>