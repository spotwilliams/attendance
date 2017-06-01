{!! Form::open(['route' => 'agentesStoreLaborales', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <span class="progress-text">Paso 2</span>
        <span class="progress-number"><b>2</b>/3</span>

        <div class="progress">
            <div class="progress-bar progress-bar-yellow" style="width: 66%"></div>
        </div>
    </div>
</div>
<input type="hidden" name="agente" value="{{$agente}}">
<div class="form-group">
    <label class="col-sm-2 control-label">ID Sial</label>
    <div class="col-sm-8">
        {!! Form::text('id_sial', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Ficha</label>
    <div class="col-sm-8">
        {!! Form::text('ficha', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Fecha de comienzo</label>
    <div class="col-sm-8">
        {!! Form::date('fecha_contrato', null, ['class' => 'form-control']) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Tipo de contrato</label>
    <div class="col-sm-8">
        <select name="tipo_contrato" class="form-control">
            @foreach(\Cat\Models\TipoContrato::all() as $tContrato)
                <option value="{{$tContrato->id}}">{{$tContrato->descripcion}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Estado de contrato</label>
    <div class="col-sm-8">
        <select name="estado_contrato" class="form-control">
            @foreach(\Cat\Models\EstadoContrato::all() as $eContrato)
                <option value="{{$eContrato->id}}">{{$eContrato->descripcion}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Siguiente', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

{!! Form::close() !!}

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('select').selectpicker({});
        });
    </script>
@append