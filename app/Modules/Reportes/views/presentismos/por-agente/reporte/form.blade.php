<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Exportar</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-4">
                <div class="user-block">
                    <img class="img-circle img-bordered-sm"
                         src="{{URL::asset('uploads/avatars/'.$agente->avatar)}}"
                         alt="foto agente">
                    <span class="username">
                          <a href="#">{{$agente->apellido}}, {{$agente->nombre}}</a>
                        </span>
                    <span class="description">{{$agente->operativo->base->nombre}}
                        - {{$agente->operativo->turno->codigo}}</span>
                </div>
            </div>
            <div class="col-xs-8">
                {{--Seleccione los datos para exportarlos a Excel!--}}
                {!! Form::open(['route' => 'reportesPresentismoIndividualExport' ,'method' => 'POST']) !!}
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Rango de fechas</label>
                    <input type="hidden" name="desde" class="desde">
                    <input type="hidden" name="hasta" class="hasta">
                    <input type="hidden" name="agente" value="{{$agente->id}}">
                    <input type="text" class="rango form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Tipos de licencias</label>
                    <div class="">
                        {!! \Cat\Helpers\HtmlCustoms::getSelectByTipoContrato($agente->contrato->tipoContrato, true, 'selectpicker', '250px') !!}
                    </div>
                </div>

                <div class="col-md-12 col-xs-12">

                <button type="submit" class="btn btn-default">Exportar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>

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