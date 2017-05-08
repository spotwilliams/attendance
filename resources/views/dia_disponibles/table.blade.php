<table class="table table-responsive" id="diaDisponibles-table">
    <thead>
        <th>Id Tipo Presentismo</th>
        <th>Cant Dias</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($diaDisponibles as $diaDisponible)
        <tr>
            <td>{!! $diaDisponible->id_tipo_presentismo !!}</td>
            <td>{!! $diaDisponible->cant_dias !!}</td>
            <td>
                {!! Form::open(['route' => ['diaDisponibles.destroy', $diaDisponible->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('diaDisponibles.show', [$diaDisponible->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('diaDisponibles.edit', [$diaDisponible->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>