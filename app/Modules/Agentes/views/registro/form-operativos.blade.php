{!! Form::open(['route' => 'agentesStoreOperativos', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <div class="progress-group">
            <span class="progress-text">Paso 3</span>
            <span class="progress-number"><b>3</b>/3</span>

            <div class="progress">
                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="agente" value="{{$agente}}">

<?php $gerencia = \Cat\Models\Gerencia::whereNull('id_padre')->get();?>

<div class="form-group">
    <label class="col-sm-2 control-label">Gerencia/Subgerencia</label>
    <div class="col-sm-8">
        <select name="gerencia" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>
            @foreach($gerencia as $g)
                <optgroup label="{{$g->nombre}}">
                    <option value="{{$g->id}}">{{$g->nombre}}</option>
                    @foreach($g->hijas()->get() as $subgerencia)
                        <option value="{{$subgerencia->id}}">{{$subgerencia->nombre}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">&Aacute;rea</label>
    <div class="col-sm-8">
        <select name="area" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>
            @foreach(\Cat\Models\Area::all() as $a)
                <option value="{{$a->id}}">{{$a->nombre}}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Cargo</label>
    <div class="col-sm-8">
        <select name="cargo" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>
            @foreach(\Cat\Models\Cargo::all() as $c)
                <option value="{{$c->id}}">{{$c->nombre}}</option>
            @endforeach
        </select>
    </div>
</div>


<?php $funcion = \Cat\Models\Funcion::whereNull('id_padre')->get();?>

<div class="form-group @if($errors->has('funcion')) has-error @endif">
    <label class="col-sm-2 control-label">Funci&oacute;n*</label>
    <div class="col-sm-8">
        <select name="funcion" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>

            @foreach($funcion as $f)
                <optgroup label="{{$f->nombre}}">
                    @foreach($f->hijas()->get() as $especifica)
                        <option value="{{$especifica->id}}">{{$especifica->nombre}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @if($errors->has('funcion'))
            <span class="help-block">{{$errors->first('funcion')}}</span>
        @endif
    </div>
</div>


<div class="form-group @if($errors->has('base')) has-error @endif">
    <label class="col-sm-2 control-label">Base*</label>
    <div class="col-sm-8">
        <select name="base" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>

            @foreach(\Cat\Models\Base::all() as $b)
                <option value="{{$b->id}}">{{$b->nombre}}</option>
            @endforeach
        </select>
        @if($errors->has('base'))
            <span class="help-block">{{$errors->first('base')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('turno')) has-error @endif">
    <label class="col-sm-2 control-label">Turno*</label>
    <div class="col-sm-8">
        <select name="turno" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>

            @foreach(\Cat\Models\Turno::all() as $t)
                <option value="{{$t->id}}">{{$t->codigo}}</option>
            @endforeach
        </select>
        @if($errors->has('turno'))
            <span class="help-block">{{$errors->first('turno')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('horario')) has-error @endif">
    <label class="col-sm-2 control-label">Horario*</label>
    <div class="col-sm-8">
        <select name="horario" class="form-control" data-live-search="true">
            <option value="-1">Seleccione...</option>

            @foreach(\Cat\Models\Horario::all() as $h)
                <option value="{{$h->id}}">{{$h->hora_entrada}} a {{$h->hora_salida}}</option>
            @endforeach
        </select>
        @if($errors->has('horario'))
            <span class="help-block">{{$errors->first('horario')}}</span>
        @endif
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-smnull0">
        {!! Form::submit('Finalizar', ['class' => 'btn btn-primary']) !!}
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