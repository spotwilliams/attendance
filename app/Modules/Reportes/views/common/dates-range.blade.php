<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right" id="rango" readonly>
    <input type="hidden" name="desde" class="form-control pull-right" id="desde" readonly>
    <input type="hidden" name="hasta" class="form-control pull-right" id="hasta" readonly>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
//            var today = moment();
                    @if(isset($desde) and $desde !== null)
            var startDate = moment('{{$desde->format('Ymd')}}', 'YYYYMMDD');
                    @else
            var startDate = moment().subtract(5, 'day');
                    @endif

                    @if(isset($desde) and $hasta !== null)
            var endDate = moment('{{$hasta->format('Ymd')}}', 'YYYYMMDD');
                    @else
            var endDate = moment().add(5, 'day');
            @endif
            $('#desde').val(startDate.format('Y-MM-DD'));
            $('#hasta').val(endDate.format('Y-MM-DD'));
            $('select').selectpicker({});
            $('#rango').daterangepicker({
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
//                    dateLimit: {
//                        days: 32
//                    },
                    showDropdowns: true,
                    startDate: startDate.format('DD/MM/Y'),
                    endDate: endDate.format('DD/MM/Y'),
                    maxDate: moment(),
                    opens: 'center',

                },
                function (start, end, label) {
                    console.log(start)
                    $('#desde').val(start.format('Y-MM-DD'));
                    $('#hasta').val(end.format('Y-MM-DD'));
                });

        })
    </script>
@append
