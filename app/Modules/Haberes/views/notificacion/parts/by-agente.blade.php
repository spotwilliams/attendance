{{ Form::open(['route' => 'notificacionSearchByAgente', 'method' => 'POST'])}}

<input type="hidden" name="periodo" value="{{$periodo->id}}">
<div class="col-md-4 form-group">
    {{ Form::text('apellido', Request::input('apellido'), ['id' => 'apellido', 'placeholder' => 'Apellido', 'class' => 'col-md-3 form-control']) }}
</div>
<div class="col-md-4 form-group">
    {{ Form::text('nombre', Request::input('nombre'), ['id' => 'nombre', 'placeholder' => 'Nombre', 'class' => 'col-md-3 form-control']) }}
</div>
<div class="col-md-4 form-group">
    {{ Form::text('cuit', Request::input('cuit'), ['id' => 'cuit', 'placeholder' => 'CUIT', 'class' => 'form-control']) }}
</div>
<div class="col-md-12 form-group">
    {{ Form::submit('Buscar', ['class' => 'btn btn-info btn-flat pull-right']) }}
</div>
{{ Form::close() }}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="cuit"]').not(':hidden').tokenfield();
        })
    </script>
@append