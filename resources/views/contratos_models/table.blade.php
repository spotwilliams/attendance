<table class="table table-responsive" id="contratosModels-table">
    <thead>
        <th>Tipo Contrato</th>
        <th>Fecha Firma</th>
        <th>Fecha Comienzo</th>
        <th>Id Estado Contrato</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($contratosModels as $contratosModel)
        <tr>
            <td>{!! $contratosModel->tipo_contrato !!}</td>
            <td>{!! $contratosModel->fecha_firma !!}</td>
            <td>{!! $contratosModel->fecha_comienzo !!}</td>
            <td>{!! $contratosModel->id_estado_contrato !!}</td>
            <td>
                {!! Form::open(['route' => ['contratosModels.destroy', $contratosModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('contratosModels.show', [$contratosModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('contratosModels.edit', [$contratosModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>