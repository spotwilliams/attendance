<table class="table table-responsive dataTable table-hover" id="areas-table">
    <thead>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th>Aplica a</th>
        <th>Editar</th>
    </thead>
    <tbody>
    @foreach($tipos as $tipo)
        <tr>
            <td>{!! $tipo->codigo !!}</td>
            <td>{!! $tipo->descripcion !!}</td>
            <td>{!! $tipo->aplica !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('configuracion.licencia.edit', [$tipo->id]) !!}" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>