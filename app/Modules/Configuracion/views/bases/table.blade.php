<table class="table table-responsive table-hover dataTable" id="baseModels-table">
    <thead>
    <th>Nombre</th>
    <th colspan="3">Editar</th>
    </thead>
    <tbody>
    @foreach($baseModels as $baseModel)
        <tr>
            <td>{!! $baseModel->nombre !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('configuracion.base.edit', [$baseModel->id]) !!}"
                       class='btn btn-primary btn-sm'>
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="{!! route('configuracion.base.delete', [$baseModel->id]) !!}"
                       class='btn btn-danger btn-sm'>
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
