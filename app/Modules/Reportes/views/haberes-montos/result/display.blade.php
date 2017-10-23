<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resultados obtenidos</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12 col-xs-12 table-responsive">
            {{--@include('Reportes::haberes.result.display')--}}
        </div>
    </div>
    <div class="box-footer text-center">
        @if(isset($haberes) and  !$haberes->isEmpty())
            {{$links}}
        @endif
    </div>
</div>
