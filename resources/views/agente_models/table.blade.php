<table class="table table-responsive" id="agenteModels-table">
    <thead>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Dni</th>
        <th>Fecha Nacimiento</th>
        <th>Cuit</th>
        <th>Id Base</th>
        <th>Id Area</th>
        <th>Id Domicilio</th>
        <th>Id Contrato</th>
        <th>Id Dias Disponibles</th>
        <th>Id Estudio</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($agenteModels as $agenteModel)
        <tr>
            <td>{!! $agenteModel->nombre !!}</td>
            <td>{!! $agenteModel->apellido !!}</td>
            <td>{!! $agenteModel->dni !!}</td>
            <td>{!! $agenteModel->fecha_nacimiento !!}</td>
            <td>{!! $agenteModel->cuit !!}</td>
            <td>{!! $agenteModel->id_base !!}</td>
            <td>{!! $agenteModel->id_area !!}</td>
            <td>{!! $agenteModel->id_domicilio !!}</td>
            <td>{!! $agenteModel->id_contrato !!}</td>
            <td>{!! $agenteModel->id_dias_disponibles !!}</td>
            <td>{!! $agenteModel->id_estudio !!}</td>
            <td>
                {!! Form::open(['route' => ['agenteModels.destroy', $agenteModel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('agenteModels.show', [$agenteModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('agenteModels.edit', [$agenteModel->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>