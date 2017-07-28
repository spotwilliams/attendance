<div class="input-group">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control pull-right" id="{{$nombreCampo}}" readonly>
    <input type="hidden" name="{{$nombreCampo}}" id="{{$nombreCampo}}">
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
                    {{--@if(isset($desde) and $desde !== null)--}}
            {{--var date = moment('{{$desde->format('Ymd')}}', 'YYYYMMDD');--}}
                    {{--@else--}}
            var date = moment();
            {{--@endif--}}

            $('#{{$nombreCampo}}').daterangepicker({
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
                    startDate: date.format('DD/MM/Y'),
                    maxDate: moment(),
                    opens: 'center',
                    autoUpdateInput: false,
                    singleDatePicker: true,

                },
                function (start, end, label) {
                    $('[name="{{$nombreCampo}}"]').val(start.format('Y-MM-DD'));
                });

        })
    </script>
@append

