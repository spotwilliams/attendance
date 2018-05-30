{{ Form::open(['route' => 'haberesSearchByAgente', 'method' => 'POST'])}}
<input type="hidden" name="periodo" value="{{$periodo->id}}">
<div class="col-md-4">
    {{ Form::text('apellido', Request::input('apellido'), ['id' => 'apellido', 'placeholder' => 'Apellido', 'class' => 'col-md-3 form-control']) }}
</div>
<div class="col-md-4">
    {{ Form::text('nombre', Request::input('nombre'), ['id' => 'nombre', 'placeholder' => 'Nombre', 'class' => 'col-md-3 form-control']) }}
</div>
<div class="col-md-4">
    <div class="input-group">
        {{ Form::text('cuit', Request::input('cuit'), ['id' => 'cuit', 'placeholder' => 'CUIT', 'class' => 'form-control']) }}
        <span class="input-group-btn">
                                {{ Form::submit('Buscar', ['class' => 'btn btn-info btn-flat']) }}
                            </span>
    </div>
</div>
{{ Form::close() }}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="cuit"]').not(':hidden').tokenfield();
        })
    </script>
@append