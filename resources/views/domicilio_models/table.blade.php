<table class="table table-responsive" id="domicilioModels-table">
    <thead>
        <th>Calle</th>
        <th>Numero</th>
        <th>Deptartamento</th>
        <th>Piso</th>
        <th>Barrio</th>
        <th>Provincia</th>
        <th>Libre</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($domicilioModels as $domicilioModel)
        <tr>
            <td>{!! $domicilioModel->calle !!}</td>
            <td>{!! $domicilioModel->numero !!}</td>
            <td>{!! $domicilioModel->deptartamento !!}</td>
            <td>{!! $domicilioModel->piso !!}</td>
            <td>{!! $domicilioModel->barrio !!}</td>
            <td>{!! $domicilioModel->provincia !!}</td>
            <td>{!! $domicilioModel->libre !!}</td>
            <td>
                {!! Form::open(['route' => ['domicilioModels.destroy', $domicilioModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('domicilioModels.show', [$domicilioModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('domicilioModels.edit', [$domicilioModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>