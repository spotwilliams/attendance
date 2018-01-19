@foreach ($agentes as $agente)
    <tr>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
        <td>{{$agente->cuit}}</td>
        <td>@if(isset($agente->operativo))
                {{$agente->operativo->base->nombre}}
            @endif
        </td>
        <td>@if(isset($agente->operativo) and $agente->operativo->turno)
                {{$agente->operativo->turno->codigo}}
            @else
                <p class="help-block">
                    No tiene asignado un turno
                </p>
            @endif
        </td>
        <td>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right rango" readonly>

            </div>
        </td>
        <td>
            {{ Form::open(['route' => 'presentismoPorAgenteRegistro', 'method' => 'POST'])}}
            {{--<input type="text" class="form-control">--}}
            <input type="hidden" name="desde" class="desde">
            <input type="hidden" name="hasta" class="hasta">
            <input type="hidden" name="agente" value="{{$agente->id}}">
            {{ Form::submit('Ir a presentismo', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </td>
    </tr>
@endforeach

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var startDate = moment().subtract(5, 'day');
            var endDate = moment().add(5, 'day');
            $('.desde').val(startDate.format('Y-MM-DD'));
            $('.hasta').val(endDate.format('Y-MM-DD'));
            $('.rango').daterangepicker({
                    locale: {
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
                    },
                    startDate: startDate.format('DD/MM/Y'),
                    endDate: endDate.format('DD/MM/Y'),
                    dateLimit: {
                        days: 10
                    },
                    opens: 'center',
                },
                function (start, end, label) {
                    console.log($(this))
                    $('.desde').val(start.format('Y-MM-DD'));
                    $('.hasta').val(end.format('Y-MM-DD'));
                });

        })
    </script>
@append
