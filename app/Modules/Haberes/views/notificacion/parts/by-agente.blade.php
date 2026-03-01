<form action="{{ route('notificacionSearchByAgente') }}" method="POST">@csrf

<input type="hidden" name="periodo" value="{{$periodo->id}}">
<div class="col-md-4 form-group">
    <input type="text" name="apellido" id="apellido" value="{{ old('apellido', Request::input('apellido')) }}" placeholder="Apellido" class="col-md-3 form-control">
</div>
<div class="col-md-4 form-group">
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', Request::input('nombre')) }}" placeholder="Nombre" class="col-md-3 form-control">
</div>
<div class="col-md-4 form-group">
    <input type="text" name="cuit" id="cuit" value="{{ old('cuit', Request::input('cuit')) }}" placeholder="CUIT" class="form-control">
</div>
<div class="col-md-12 form-group">
    <button type="submit" class="btn btn-info btn-flat pull-right">Buscar</button>
</div>
</form>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="cuit"]').not(':hidden').tokenfield();
        })
    </script>
@append
