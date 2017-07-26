<table class="table table-responsive dataTable table-hover" id="areas-table">
    <thead>
        <th>Nombre</th>
        <th colspan="3">Editar</th>
    </thead>
    <tbody>
    @foreach($areas as $area)
        <tr>
            <td>{!! $area->nombre !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('configuracion.area.edit', [$area->id]) !!}" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>