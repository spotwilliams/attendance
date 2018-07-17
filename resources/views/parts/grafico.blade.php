<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Presentismos de la semana</h3>

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
                            <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                            <span class="progress-text">Add Products to Cart</span>
                            <span class="progress-number"><b>160</b>/200</span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Complete Purchase</span>
                            <span class="progress-number"><b>310</b>/400</span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Visit Premium Page</span>
                            <span class="progress-number"><b>480</b>/800</span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Send Inquiries</span>
                            <span class="progress-number"><b>250</b>/500</span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
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

            function newDateString(days) {
                return moment().add(days, 'd').format(timeFormat);
            }

            var color = Chart.helpers.color;
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
                            label: 'Agentes activos del cuerpo ',
                            // backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.red,
                            data: [
                                @foreach($fechas as $fecha)
                                {{--{{$cantAgentes}},--}}
                                {{($activosByDay->get($fecha)) ? $activosByDay->get($fecha)->agentes : $cantAgentes}},

                                @endforeach

                            ],
                        },
                        {
                            type: 'line',
                            label: 'Presentismo cargado',
                            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.blue,
                            data: [
                                @foreach($fechas as $fecha)
                                {{($presentByDay->get($fecha)) ? $presentByDay->get($fecha)->presentismo : 0}},
                                @endforeach
                            ],
                        },]
                },
                options: {
                    title: {
                        // text: 'Chart.js Combo Time Scale'
                    },
                    // scales: {
                    //     xAxes: [{
                    //         type: 'integer',
                    //         display: true,
                    //         time: {
                    format: timeFormat,
                    round: 'day'
                    // }
                    // }],
                    // },
                }
            };

            // window.onload = function () {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myLine = new Chart(ctx, config);


        });
    </script>
@append