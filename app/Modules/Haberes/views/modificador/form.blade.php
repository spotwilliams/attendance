<?php
$gerencias = \Cat\Models\Gerencia::whereNull('id_padre')->get(['id', 'nombre']);
//foreach (\Cat\Models\Gerencia::whereNull('id_padre')->get(['id', 'nombre']) as $geren) {
//    /** @var \Cat\Models\Gerencia $geren */
//    /** @var \Cat\Models\Gerencia $subgerencia */
//    $gerencias[$geren->nombre] = [
//        $geren->id => $geren->nombre
//    ];
//
//    foreach ($geren->hijas()->get(['id', 'nombre']) as $subgerencia) {
//        $gerencias[$geren->nombre] [$subgerencia->id] = $subgerencia->nombre;
//    }
//}
$gerenciasOld = old('gerencias') === null ? [] : old('gerencias');

?>

{!! Form::open(['route' => 'modificacionMasivaContratosDisclosure', 'method' => 'POST', 'class' => 'form-horizontal']) !!}


<div class="form-group @if($errors->has('gerencias')) has-error @endif">
    <label class="col-sm-4 control-label">Gerencia/Subgerencia</label>
    <div class="col-sm-6">
        <select name="gerencias[]" class="form-control" data-live-search="true" multiple>
            @foreach($gerencias as $padre)
                <optgroup label="{{$padre->nombre}}">
                    <option value="{{$padre->id}}"
                            @if(in_array($padre->id, $gerenciasOld)) selected @endif>{{$padre->nombre}}</option>
                    @foreach($padre->hijas()->get(['id', 'nombre']) as $g)
                        <option value="{{$g->id}}"
                                @if(in_array($g->id, $gerenciasOld)) selected @endif>{{$g->nombre}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        {{--        {!! Form::select('gerencias[]',  $gerencias, old('gerencias'), ['class' => 'form-control', 'data-live-search'=>'true', 'multiple' => true]) !!}--}}
        @if($errors->has('gerencias'))
            <span class="help-block">{{$errors->first('gerencias')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('fecha_contrato')) has-error @endif">
    <label class="col-sm-4 control-label">Fecha de ingreso modalidad actual *</label>
    <div class="col-sm-6">
        {!! Form::hidden('fecha_contrato', null, ['class' => 'form-control']) !!}
        <input type="text" name="fecha_contrato_show" class="form-control">
        @if($errors->has('fecha_contrato'))
            <span class="help-block">{{$errors->first('fecha_contrato')}}</span>
        @endif
    </div>
</div>
<div class="form-group @if($errors->has('monto')) has-error @endif">
    <label class="col-sm-4 control-label">Monto</label>
    <div class="col-sm-6">
        {!! Form::text('monto', null, ['class' => 'form-control', 'placeholder' => '$ 0']) !!}
        @if($errors->has('monto'))
            <span class="help-block">{{$errors->first('monto')}}</span>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label"></label>
    <div class="col-sm-6">
        {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
    </div>
</div>

{!! Form::close() !!}

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
            var day = moment('{{date('Y')}}-01-01');

            if ($('[name="fecha_contrato"]').val() !== '') {
                day = moment($('[name="fecha_contrato"]').val());
            } else {
                $('[name="fecha_contrato"]').val(day.format('Y-MM-DD'));

            }

            $('[name="fecha_contrato_show"]').val(day.format('Y-MM-DD'));


            var locale = {
                format: 'DD/MM/YYYY',
                separator: " - ",
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                fromLabel: "Desde",
                toLabel: "Hasta",
                weekLabel: "W",
                daysOfWeek: [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mie",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
            };

            $('[name="fecha_contrato_show"]')
                .val(day.format('DD/MM/YYYY'))
                .daterangepicker({
                        locale: locale,
                        showDropdowns: true,
                        singleDatePicker: true,
                        opens: 'center',
                    },
                    function (start, end, label) {
                        $('[name="fecha_contrato"]').val(start.format('Y-MM-DD'))
                    });

        });
    </script>
@append
