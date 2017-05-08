<table class="table table-responsive" id="domicilios-table">
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
    @foreach($domicilios as $domicilio)
        <tr>
            <td>{!! $domicilio->calle !!}</td>
            <td>{!! $domicilio->numero !!}</td>
            <td>{!! $domicilio->deptartamento !!}</td>
            <td>{!! $domicilio->piso !!}</td>
            <td>{!! $domicilio->barrio !!}</td>
            <td>{!! $domicilio->provincia !!}</td>
            <td>{!! $domicilio->libre !!}</td>
            <td>
                {!! Form::open(['route' => ['domicilios.destroy', $domicilio->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('domicilios.show', [$domicilio->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('domicilios.edit', [$domicilio->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>