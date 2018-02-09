{{ Form::open(['route' => 'reportesPresentismoIndividualSearch', 'method' => 'POST', 'class' => 'form-horizontal'])}}
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