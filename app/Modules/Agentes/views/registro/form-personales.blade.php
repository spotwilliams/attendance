{!! Form::open(['route' => 'agentesStorePersonales', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <span class="progress-text">Paso 1</span>
        <span class="progress-number"><b>1</b>/3</span>

        <div class="progress">
            <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
        </div>
    </div>
</div>


<div class="form-group @if($errors->has('nombre')) has-error @endif">
    {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
        @if($errors->has('nombre'))
            <span class="help-block">{{$errors->first('nombre')}}</span>
        @endif
    </div>
</div>


<div class="form-group @if($errors->has('apellido')) has-error @endif">
    {!! Form::label('apellido', 'Apellido', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
        @if($errors->has('apellido'))
            <span class="help-block">{{$errors->first('apellido')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('dni')) has-error @endif">
    {!! Form::label('dni', 'Dni', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('dni', null, ['class' => 'form-control']) !!}
        @if($errors->has('dni'))
            <span class="help-block">{{$errors->first('dni')}}</span>
        @endif
    </div>
</div>


<div class="form-group @if($errors->has('fecha_nacimiento')) has-error @endif">
    {!! Form::label('fecha_nacimiento', 'Fecha de nacimiento', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control']) !!}
        @if($errors->has('fecha_nacimiento'))
            <span class="help-block">{{$errors->first('fecha_nacimiento')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('cuit')) has-error @endif">
    {!! Form::label('cuit', 'CUIT', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('cuit', null, ['class' => 'form-control']) !!}
        @if($errors->has('cuit'))
            <span class="help-block">{{$errors->first('cuit')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        @if($errors->has('email'))
            <span class="help-block">{{$errors->first('email')}}</span>
        @endif
    </div>
</div>


{{-- Estudios --}}
<div class="form-group">
    {!! Form::label('estudios', 'Estudios', ['class' => 'col-sm-2 control-label']) !!}

    <div class="panel panel-default col-sm-8">
        <div class="panel-body estudiosWrapper">
            <div class="form-group estudiosTemplate" id="estudiosTemplate">
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Carrera" name="estudio[carrera][]">
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Instituci&oacute;n" name="estudio[institucion][]">

                </div>

                <div class="col-sm-2">
                    <select name="estudio[nivelestudio][]" class="form-control">
                        <option value="SECUNDARIO">Secundario</option>
                        <option value="TERCIARIO">Terciario</option>
                        <option value="UNIVERSITARIO">Universitario</option>
                        <option value="POSGRADO">Posgrado</option>
                        <option value="MASTER">Master</option>
                        <option value="DOCTORADO">Doctorado</option>
                        <option value="OTRO">Otro</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="estudio[estado][]" class="form-control">
                        <option value="CURSANDO">Cursando</option>
                        <option value="ABANDONADO">Dej&oacute;</option>
                        <option value="RECIBIDO">Recibido</option>
                    </select>
                </div>
                <div class="col-xs-2">
                    <button type="button" class="btn btn-success addButton">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger removeButton hidden">
                        <i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Domicilios --}}
<div class="form-group">
    {!! Form::label('domicilio', 'Domicilio', ['class' => 'col-sm-2 control-label']) !!}

    <div class="panel panel-default col-sm-8">
        <div class="panel-body domiciliosWrapper">
            <div class="domiciliosTemplate" id="domiciliosTemplate">
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Calle" name="domicilio[calle][]">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="N&uacute;mero" name="domicilio[numero][]">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Departamento" name="domicilio[departamento][]">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Piso" name="domicilio[piso][]">
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Barrio" name="domicilio[barrio][]">
                    </div>

                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Provincia" name="domicilio[provincia][]">
                    </div>

                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Otro" name="domicilio[otro][]">
                    </div>

                    <div class="col-sm-3">
                        <button type="button" class="btn btn-success addButton">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger removeButton hidden">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
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

            $('.estudiosTemplate .addButton').on('click', function (obj, event) {


                var $template = $('#estudiosTemplate');

                var $clone = $template
                        .clone()
                        .removeAttr('id')
                        .insertAfter($template);

                var $option = $clone
                        .find('input')
                        .val('');
                $option.find('[name="carrera[]"]')
                        .focus();
                //button

                $clone.find('.btn-success')
                        .addClass('hidden');

                $clone.find('.btn-danger')
                        .removeClass('hidden');

            });
            $('.estudiosWrapper').on("click", ".removeButton", function (e) {
                e.preventDefault();
                $(this)
                        .parents()
                        .closest('.form-group.estudiosTemplate')
                        .remove();

            });

            $('.domiciliosTemplate .addButton').on('click', function (obj, event) {


                var $template = $('#domiciliosTemplate');

                var $clone = $template
                        .clone()
                        .removeAttr('id')
                        .insertAfter($template);

                var $option = $clone
                        .find('input')
                        .val('');
                $option.find('[name="carrera[]"]')
                        .focus();
                //button

                $clone.find('.btn-success')
                        .addClass('hidden');

                $clone.find('.btn-danger')
                        .removeClass('hidden');

            });
            $('.domiciliosWrapper').on("click", ".removeButton", function (e) {
                e.preventDefault();
                $(this)
                        .parents()
                        .closest('.domiciliosTemplate')
                        .remove();


            });
        });

    </script>

@append
