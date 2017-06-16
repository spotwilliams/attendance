@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        @include('Presentismo::registro.form-box')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
//            var today = moment();
            var startDate = moment().subtract(5, 'day');
            var endDate = moment().add(5, 'day');
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
                    startDate: startDate.format('DD/MM/Y'),
                    endDate: endDate.format('DD/MM/Y'),
                    dateLimit: {
                        days: 10
                    },
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

