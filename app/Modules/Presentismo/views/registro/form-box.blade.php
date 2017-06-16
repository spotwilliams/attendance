<div class="box box-warning @if(isset($collapsed)) collapsed-box @endif">
    <div class="box-header with-border">
        @if(isset($title))
            <h3 class="box-title">{{$title}}</h3>

        @else

            <h3 class="box-title">Registro de presentismo</h3>
        @endif
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa @if(isset($collapsed)) fa-plus @else fa-minus @endif "></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    {!! Form::open(['route' => 'presentismoPrepareListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}

    <div class="box-body">
        <div class="col-md-offset-2 col-md-8">

            <div class="form-group @if($errors->has('base')) has-error @endif">
                @include('bases.select-sin-btn' ,['label'=> 'Seleccione la base', 'baseSeleccionada' => '-1'])
                @if($errors->has('base'))
                    <span class="help-block col-md-offset-3 col-xs-offset-3">{{$errors->first('base')}}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="col-md-3 col-xs-3 control-label">Rango de fechas</label>

                <div class="col-sm-9 col-xs-9">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="rango" readonly>
                        <input type="hidden" name="desde" class="form-control pull-right" id="desde" readonly>
                        <input type="hidden" name="hasta" class="form-control pull-right" id="hasta" readonly>
                    </div>
                </div>
                <!-- /.input group -->
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
    </div>
    {!! Form::close() !!}
</div>


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
                    $('#desde').val(start.format('Y-MM-DD'));
                    $('#hasta').val(end.format('Y-MM-DD'));
                });

        })
    </script>
@append

