<!-- Info boxes -->
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-number">Periodo actual</span>
                <span class="info-box-text">{{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}} - {{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-hourglass-end"></i></span>

            <div class="info-box-content">
                <span class="info-box-number">Fecha cierre periodo</span>
                <span class="info-box-text">{{$fechaCierre->valor}} del presente</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
                <span class="info-box-number">&Iacute;ndice presentismo periodo</span>
                <span class="info-box-text">{{$indicePresen}} %</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-number">Agentes activos</span>
                <span class="info-box-text">{{$cantAgentes}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
<!-- /.row -->