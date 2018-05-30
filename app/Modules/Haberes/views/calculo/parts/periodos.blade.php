{{ Form::open(['route' => 'haberesSearch', 'method' => 'POST', 'class' => 'form-horizontal'])}}
<div class="form-group">
    <label class="col-sm-3 control-label">Facturaci&oacute;n de</label>

    <div class="col-sm-6">

        <select name="periodo" data-width="300px">
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="periodo"]').selectpicker()
        })
    </script>
@append