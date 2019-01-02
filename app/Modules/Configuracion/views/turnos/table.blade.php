<table class="table table-responsive table-hover dataTable" id="turnoModels-table">
    <thead>
        <th>Codigo</th>
        <th>Descripci&oacute;n</th>
        <th colspan="3">Editar</th>
    </thead>
    <tbody>
    @foreach($turnoModels as $turnoModel)
        <tr>
            <td>{!! $turnoModel->codigo !!}</td>
            <td>{!! $turnoModel->descripcion !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('configuracion.turno.edit', [$turnoModel->id]) !!}" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                    <a href="{!! route('configuracion.turno.delete', [$turnoModel->id]) !!}"
                       class='btn btn-danger btn-sm'>
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>