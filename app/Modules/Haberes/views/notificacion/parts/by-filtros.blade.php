<form action="{{ route('notificacionSearchByFiltros') }}" method="POST" class="form-horizontal" role="form">@csrf

<input type="hidden" name="periodo" value="{{$periodo->id}}">

<div class="col-md-12">
    @include('common.bases.as-checkbox', ['label' => 'Bases'])
</div>
<div class="col-md-12">

    @include('common.turnos.as-checkbox', ['label' => 'Turnos'])
</div>
<div class="col-md-12">

    @include('common.funcion.as-checkbox', ['label' => 'Funciones'])
</div>
<div class="col-md-12">

    @include('common.areas.as-checkbox', ['label' => '&Aacute;reas'])
</div>
<div class="col-md-12">

    @include('common.estado-contratos.as-checkbox', ['label' => 'Estado contrato'])
</div>
{{--<div class="col-md-12">--}}

{{--    @include('common.tipo-contratos.as-checkbox', ['label' => 'Tipo contrato'])--}}
{{--</div>--}}

<div class="col-md-12">
    <button type="submit" class="btn btn-info pull-right btn-flat">Buscar</button>

</div>

</form>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            // $('select').selectpicker({
            //     container: '.lista-tipos'
            // });
        })
    </script>
@append
