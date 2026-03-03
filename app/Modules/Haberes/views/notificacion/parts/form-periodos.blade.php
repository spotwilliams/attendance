
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <span role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                   >> Seleccione un periodo de la lista siguiente
                </span>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <form action="{{ route('notificacionSearch') }}" method="POST" class="form-horizontal">@csrf
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

            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="periodo"]').selectpicker()
        })
    </script>
@append
