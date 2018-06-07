
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
                {{ Form::open(['route' => 'notificacionSearch', 'method' => 'POST', 'class' => 'form-horizontal'])}}
                <div class="form-group">
                    <label class="col-sm-3 control-label">Facturaci&oacute;n de</label>

                    <div class="col-sm-6">

                        <select name="periodo" data-width="300px" data-live-search="true">
                            @foreach(\Cat\Models\Periodo::select(['*'])->orderBy('fecha_comienzo', 'DESC')->get() as $periodo)
                                <?php

                                $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
                                $mesFacturacion->addMonth(1);

                                $start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
                                $end = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
                                ?>
                                <option value="{{$periodo->id}}">{{trans('month.'.$mesFacturacion->format('m'))}}
                                    '{{$mesFacturacion->format('y')}} ({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" value="Siguiente" class="btn btn-primary">
                    </div>
                </div>


                {{ Form::close() }}

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