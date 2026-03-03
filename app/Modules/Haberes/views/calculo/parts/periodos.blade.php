<form action="{{ route('haberesSearch') }}" method="POST" class="form-horizontal">@csrf
<div class="form-group">
    <label class="col-sm-3 control-label"></label>

    <div class="col-sm-6">
        @include('common.periodos.as-select-v2', ['label' => 'Facturaci&oacute;n de'])
    </div>
    <div class="col-md-3">
        <input type="submit" value="Siguiente" class="btn btn-primary">
    </div>
</div>


</form>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="periodo"]').selectpicker()
        })
    </script>
@append