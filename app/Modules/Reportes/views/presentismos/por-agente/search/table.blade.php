<table class="table table-hover">
    <thead>
    <th></th>
    <th>Personal</th>
    <th>CUIT</th>
    <th>Base</th>
    <th>Acci&oacute;n</th>
    </thead>
    <tbody>
    @foreach ($agentes as $agente)
        <tr>
            <td><a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover" title="Ver datos"
                   data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank"
                   class="label label-success"><i class="fa fa-eye"></i></a></td>
            <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
            <td>{{$agente->cuit}}</td>
            <td>@if(isset($agente->operativo))
                    {{$agente->operativo->base->nombre}}
                @endif
            </td>
            <td>
                @if($agente->contrato)
                    {{ Form::open(['route' => 'reportesPresentismoIndividualReportePresentismos', 'method' => 'POST'])}}
                    <input type="hidden" name="agente" value="{{$agente->id}}">
                    {!! \Cat\Helpers\HtmlCustoms::getSelectByTipoContrato($agente->contrato->tipoContrato, true, 'selectpicker', '200px') !!}
                    {{ Form::submit('Reporte', ['class' => 'btn btn-primary']) }}

                    {{ Form::close() }}
                @else
                    <p class="help-block">El agente no tiene datos laborales u operativos para poder trabajar</p>
                @endif

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
                            days: 365
                        },
                        opens: 'center',
                    },
                    function (start, end, label) {
                        $('.desde').val(start.format('Y-MM-DD'));
                        $('.hasta').val(end.format('Y-MM-DD'));
                    });

            })
        </script>
    @append

    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover({
                    trigger: 'hover'
                });
            })
        </script>
    @append
    </tbody>
</table>