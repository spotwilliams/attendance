{{ Form::open(['route' => 'reportesPresentismoIndividualSearch', 'method' => 'POST'])}}
<div class="input-group input-group-sm">
    {{--<input type="text" class="form-control">--}}
    {{ Form::text('search', null, ['id' => 'search', 'placeholder' => 'Ingrese un nombre o CUIT o DNI', 'class' => 'form-control']) }}
    <span class="input-group-btn">
                                {{--<button type="button" class="btn btn-info btn-flat">Buscar!</button>--}}
        {{ Form::submit('Buscar', ['class' => 'btn btn-info btn-flat']) }}
                            </span>
</div>
{{ Form::close() }}