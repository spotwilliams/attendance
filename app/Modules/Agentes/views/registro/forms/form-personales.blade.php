{!! Form::hidden('id', null, ['class' => 'form-control']) !!}

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
    {!! Form::label('nombre', 'Nombre *', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
        @if($errors->has('nombre'))
            <span class="help-block">{{$errors->first('nombre')}}</span>
        @endif
    </div>
</div>


<div class="form-group @if($errors->has('apellido')) has-error @endif">
    {!! Form::label('apellido', 'Apellido *', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('apellido', null, ['class' => 'form-control']) !!}
        @if($errors->has('apellido'))
            <span class="help-block">{{$errors->first('apellido')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('dni')) has-error @endif">
    {!! Form::label('dni', 'DNI *', ['class' => 'col-sm-2 control-label']) !!}
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
        {!! Form::hidden('fecha_nacimiento', null, ['class' => 'form-control']) !!}
        <input type="text" name="fecha_nacimiento_show" class="form-control">
        {{--        {!! Form::text('fecha_nacimiento', null, ['class' => 'form-control']) !!}--}}
        @if($errors->has('fecha_nacimiento'))
            <span class="help-block">{{$errors->first('fecha_nacimiento')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('cuit')) has-error @endif">
    {!! Form::label('cuit', 'CUIT *', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('cuit', null, ['class' => 'form-control']) !!}
        @if($errors->has('cuit'))
            <span class="help-block">{{$errors->first('cuit')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Email *', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        @if($errors->has('email'))
            <span class="help-block">{{$errors->first('email')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('telefono')) has-error @endif">
    {!! Form::label('telefono', 'Telefono de contacto *', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
        @if($errors->has('telefono'))
            <span class="help-block">{{$errors->first('telefono')}}</span>
        @endif
    </div>
</div>


<div class="form-group">
    {!! Form::label('estado_civil', 'Estado Civil', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::select('estado_civil',
         [
         'CASADO'=> 'Casado',
         'SOLTERO' => 'Soltero',
         'VIUDO' => 'Viudo',
         'CONCUBINATO' => 'Concubinato',
         'SEPARADO DE HECHO' => 'Separado de hecho',
         'UNION CIVIL' => 'Uni&oacute;n civil',
         'DIVORCIADO' => 'Divorciado'
          ], null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('sexo', 'Sexo', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::select('sexo',
         [
         'F' => 'Mujer',
         'M' => 'Hombre',
          ], null, ['class' => 'form-control']) !!}
    </div>
</div>
{{-- Estudios --}}
<?php
$data = [];
if (isset($agente)) {
    $data = [
        'model' => $agente,
    ];
}
if (!empty(session()->getOldInput())) {
    $data = [
        'session' => session()->getOldInput(),
    ];
}
$estudios = \Cat\Helpers\HtmlCustoms::getEstudiosArray($data);
$control = 0;
?>
<div class="form-group">
    {!! Form::label('estudios', 'Estudios', ['class' => 'col-sm-2 control-label']) !!}

    <div class="panel panel-default col-sm-8">
        @foreach($estudios  as $est)

            <?php $control++;?>

            <div class="panel-body estudiosWrapper">
                <div class="form-group estudiosTemplate" id="estudiosTemplate">
                    <input type="hidden" class="form-control" value="{{$est['id']}}" placeholder="Carrera"
                           name="estudio[id][]">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="{{$est['carrera']}}" placeholder="T&iacute;tulo"
                               name="estudio[carrera][]">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="{{$est['institucion']}}"
                               placeholder="Instituci&oacute;n"
                               name="estudio[institucion][]">

                    </div>

                    <div class="col-sm-2">
                        <select name="estudio[nivelestudio][]" class="form-control">
                            <option value="SECUNDARIO" {{$est['nivel']=='SECUNDARIO'? 'selected': ''}}>Secundario
                            </option>
                            <option value="TERCIARIO" {{$est['nivel']=='TERCIARIO'? 'selected': ''}}>Terciario</option>
                            <option value="UNIVERSITARIO" {{$est['nivel']=='UNIVERSITARIO'? 'selected': ''}}>
                                Universitario
                            </option>
                            <option value="POSGRADO" {{$est['nivel']=='POSGRADO'? 'selected': ''}}>Posgrado</option>
                            <option value="MASTER" {{$est['nivel']=='MASTER'? 'selected': ''}}>Master</option>
                            <option value="DOCTORADO" {{$est['nivel']=='DOCTORADO'? 'selected': ''}}>Doctorado</option>
                            <option value="OTRO" {{$est['nivel']=='OTRO'? 'selected': ''}}>Otro</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="estudio[estado][]" class="form-control">
                            <option value="COMPLETO">Completo</option>
                            <option value="INCOMPLETO">Incompleto</option>
                            <option value="EN CURSO">En curso</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-success addButton {{$control == 1? '' : 'hidden'}}">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger removeButton {{$control == 1? 'hidden':''}}">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>


{{-- Domicilios --}}
<div class="form-group">
    {!! Form::label('domicilio', 'Domicilio *', ['class' => 'col-sm-2 control-label']) !!}
    <?php
    $data = [];
    if (isset($agente)) {
        $data = [
            'model' => $agente,
        ];
    }
    if (!empty(session()->getOldInput())) {
        $data = [
            'session' => session()->getOldInput(),
        ];
    }
    $domicilios = \Cat\Helpers\HtmlCustoms::getDomiciliosArray($data);
    $control = -1;
    ?>
    <div class="panel panel-default col-sm-8">
        @foreach($domicilios as $key =>$dom)
            <?php $control++;?>

            <div class="panel-body">
                <input type="hidden" class="form-control" value="{{$dom['id']}}" placeholder="Carrera"
                       name="domicilio[id][]">
                <div class="form-group">
                    <div class="col-sm-6 @if($errors->has("domicilio.calle.$control" )) has-error @endif">
                        <input type="text" class="form-control" value="{{$dom['calle']}}" placeholder="Calle"
                               name="domicilio[calle][]">
                        @if($errors->has("domicilio.calle.$control"))
                            <span class="help-block">{{$errors->first("domicilio.calle.$control")}}</span>
                        @endif

                    </div>
                    <div class="col-sm-2 @if($errors->has("domicilio.numero.$control" )) has-error @endif">
                        <input type="text" class="form-control" value="{{$dom['numero']}}"
                               placeholder="N&uacute;mero"
                               name="domicilio[numero][]">
                        @if($errors->has("domicilio.numero.$control"))
                            <span class="help-block">{{$errors->first("domicilio.numero.$control")}}</span>
                        @endif

                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="{{$dom['departamento']}}"
                               placeholder="Departamento"
                               name="domicilio[departamento][]">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" value="{{$dom['piso']}}" placeholder="Piso"
                               name="domicilio[piso][]">
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{$dom['barrio']}}" placeholder="Barrio"
                               name="domicilio[barrio][]">
                    </div>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{$dom['provincia']}}"
                               placeholder="Provincia"
                               name="domicilio[provincia][]">
                    </div>


                    <div class="col-sm-2">
                        <h4> <span class="label label-default">
                                @if($dom['constituido'] == true)
                                    Constituido
                                @else
                                    Real
                                @endif
                            </span>
                        </h4>
                        <input type="hidden" name="domicilio[constituido][]" value="{{$dom['constituido']== true ?1:0}}"/>
                    </div>


                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{$dom['libre']}}" placeholder="Otro"
                               name="domicilio[libre][]">
                    </div>
                </div>
                <hr>
            </div>
        @endforeach
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Siguiente', ['class' => 'btn btn-primary']) !!}
        <a href="{{URL::previous()}}" class="btn btn-default col-sm-offset-8">Volver</a>
    </div>
</div>




@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.estudiosTemplate .addButton').on('click', function (obj, event) {


                // Template
                var $template = $('#estudiosTemplate');

                // Ubico los datos actuales
                var inptus = $template.find('input');
                var selects = $template.find('select');

                // Realizo la copia y quito el id para no copiar repetidos
                var $clone = $template
                    .clone()
                    .removeAttr('id')
                    .insertAfter($template);

                // Escondo los botones success y muestro el close
                $clone.find('.btn-success')
                    .addClass('hidden');


                $clone.find('.btn-danger')
                    .removeClass('hidden');

                // Pongo los datos en la nueva fila creada
                var inputsCopy = $clone.find('input');
                var selectsCopy = $clone.find('select');

                for (var i = 0; i < 2; i++) {
                    $(inputsCopy[i]).val($(inptus[i]).val());
                    $(selectsCopy[i]).val($(selects[i]).val());
                }

                // Saco los datos en la linea actual
                $template
                    .find('input')
                    .val('');
                $(inptus[0]).focus();

            });
            $('.estudiosWrapper').on("click", ".removeButton", function (e) {
                e.preventDefault();
                $(this)
                    .parents()
                    .closest('.form-group.estudiosTemplate')
                    .remove();

            });

            if ($('[name="fecha_nacimiento"]').val() === '') {
                var day = moment();
                $('[name="fecha_nacimiento"]').val(day.format('Y-MM-DD'))
            } else {
                var day = moment($('[name="fecha_nacimiento"]').val());
            }

            $('[name="fecha_nacimiento_show"]')
                .val(day.format('DD/MM/YYYY'))
                .daterangepicker({
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
                        showDropdowns: true,
                        singleDatePicker: true,
                        opens: 'center',
                    },
                    function (start, end, label) {
                        $('[name="fecha_nacimiento"]').val(start.format('Y-MM-DD'))
//                    console.log($('[name="fecha_nacimiento"]').val())
                    });

        });

    </script>

@append
