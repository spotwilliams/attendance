<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Presentismo a 5 d&iacute;as</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong></strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="canvas" style="height: 520px; width: 620px;" width="620"
                                    height="320"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">

                        <p class="text-center">
                            <strong>Hoy</strong> (presentismo/agentes)
                        </p>
                        <div class="parent-template" style="overflow: scroll; max-height: 420px; padding-left: 10px; padding-right: 10px">

                            <div class="progress-group hidden template-progress">
                                <span class="progress-text base-name"></span>
                                <span class="progress-number"><b><span class="presentismo"></span></b>/<span
                                            class="agentes"></span></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                var timeFormat = 'MM/DD/YYYY HH:mm';

                var color = Chart.helpers.color;

                var fechas = {!! json_encode($fechas, false) !!};
                var config = {
                    type: 'line',
                    data: {
                        labels: [
                            // "Red", "Blue", "Yellow", "Green", "Purple",
                            @foreach($fechas as $fecha)
                            moment('{{$fecha}}').format('D/MM/Y'),
                            @endforeach
                            // 'Agentes activos del cuerpo',
                            // 'Presentismo cargado',
                        ],
                        datasets: [
                            {
                                type: 'line',
                                label: 'Agentes activos ',
                                // backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                                borderColor: window.chartColors.red,
                                data: [
                                    // Ver ajax
                                ],
                            },
                            {
                                type: 'line',
                                label: 'Presentismo cargado',
                                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                                borderColor: window.chartColors.blue,
                                data: [
                                    // Ver ajax
                                ],
                            },]
                    },
                    options: {
                        format: timeFormat,
                        round: 'day'
                    }
                };

                $.getJSON('{{route('home.grafico')}}', function (data) {
                    // Array de retorno
                    var activos = [
                        @foreach($fechas as $fecha)
                        {{$cantAgentes}},
                        @endforeach
                    ];
                    var posibleIndex = -1;
                    $.each(data['activosByDay'], function (key, val) {
                        posibleIndex = $.inArray(key.toString(), fechas);

                        if (posibleIndex !== -1) {
                            activos[posibleIndex] = parseInt(val.agentes);
                        }
                    });
                    config.data.datasets[0].data = activos;


                    posibleIndex = -1;
                    var presentismos = [
                        @foreach($fechas as $fecha)
                            0,
                        @endforeach
                    ];
                    $.each(data['presentByDay'], function (key, val) {
                        posibleIndex = $.inArray(key.toString(), fechas);

                        if (posibleIndex !== -1) {
                            presentismos[posibleIndex] = parseInt(val.presentismo);
                        }
                    });
                    config.data.datasets[1].data = presentismos;

                    var ctx = document.getElementById('canvas').getContext('2d');
                    window.myLine = new Chart(ctx, config);
                });

                $.getJSON('{{route('home.bases')}}', function (data) {

                    var $parent = $('.template-progress').parent();
                    $.each(data, function (key, val) {

                        $template = $('.template-progress').clone();

                        $template.find('span.base-name').html(val.nombre);
                        $template.find('span.presentismo').html(val.presentismo.presentismo);
                        $template.find('span.agentes').html(val.agentes.agentes);
                        $template.find('div.progress-bar').css('width', (val.presentismo.presentismo * 100 / val.agentes.agentes) + '%');
                        $template.removeClass('template-progress hidden');
                        $parent.append($template);
                    });

                })
            });
        </script>
@append