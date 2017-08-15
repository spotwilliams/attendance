<?php
$desdeName = (isset($nombreCampo) ? $nombreCampo . '_desde' : 'desde');
$hastaName = (isset($nombreCampo) ? $nombreCampo . '_hasta' : 'hasta')
?>

<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right rango_{{$nombreCampo}}" readonly>
    <input type="hidden" name="{{$desdeName}}" class="form-control pull-right" id="{{$desdeName}}" readonly>
    <input type="hidden" name="{{$hastaName}}" class="form-control pull-right" id="{{$hastaName}}" readonly>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var startDate = moment().subtract(5, 'day');
            var endDate = moment().add(5, 'day');

            $('select').selectpicker({});
            $('.rango_{{$nombreCampo}}').daterangepicker({
                    locale: {
                        format: 'DD/MM/YYYY',
                        separator: " - ",
                        applyLabel: "Aplicar",
                        cancelLabel: "Limpiar",
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
                    dateLimit: {
                        days: 31
                    },
                    showDropdowns: true,
                    autoUpdateInput: false,
                    startDate: startDate.format('DD/MM/Y'),
                    endDate: endDate.format('DD/MM/Y'),
                    maxDate: moment(),
                    opens: 'center',

                },
                function (start, end, label) {
                    $('#{{$desdeName}}').val(start.format('Y-MM-DD'));
                    $('#{{$hastaName}}').val(end.format('Y-MM-DD'));
                });

            $('.rango_{{$nombreCampo}}').on('apply.daterangepicker', function (ev, picker) {
                $('#{{$desdeName}}').val(picker.startDate.format('Y-MM-DD'));
                $('#{{$hastaName}}').val(picker.endDate.format('Y-MM-DD'));
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.rango_{{$nombreCampo}}').on('cancel.daterangepicker', function (ev, picker) {
                $('#{{$desdeName}}').val('');
                $('#{{$hastaName}}').val('');
                $(this).val('');
            });

        })
    </script>
@append
