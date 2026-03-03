<form action="{{ route('reportesPresentismoIndividualSearch') }}" method="POST" class="form-horizontal">@csrf
<div class="col-md-4">
    <input type="text" name="apellido" id="apellido" value="{{ old('apellido', Request::input('apellido')) }}" placeholder="Apellido" class="col-md-3 form-control">
</div>
<div class="col-md-4">
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', Request::input('nombre')) }}" placeholder="Nombre" class="col-md-3 form-control">
</div>
<div class="col-md-4">
    <div class="input-group">
        <input type="text" name="cuit" id="cuit" value="{{ old('cuit', Request::input('cuit')) }}" placeholder="CUIT" class="form-control">
        <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                            </span>
    </div>
</div>
</form>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="cuit"]').not(':hidden').tokenfield();
        })
    </script>
@append
