<input type="hidden" name="id" id="id" value="{{ old('id') }}">

<div class="form-group">
    <div class="progress-group col-sm-8 col-sm-offset-2">
        <span class="progress-text">Paso 1</span>
        <span class="progress-number"><b>1</b>/3</span>

        <div class="progress">
            <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">

        <div class="form-group @if($errors->has('nombre')) has-error @endif">
            <label for="nombre" class="col-sm-3 control-label">Nombre *</label>
            <div class="col-sm-9">
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control">
                @if($errors->has('nombre'))
                    <span class="help-block">{{$errors->first('nombre')}}</span>
                @endif
            </div>
        </div>


        <div class="form-group @if($errors->has('apellido')) has-error @endif">
            <label for="apellido" class="col-sm-3 control-label">Apellido *</label>
            <div class="col-sm-9">
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" class="form-control">
                @if($errors->has('apellido'))
                    <span class="help-block">{{$errors->first('apellido')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('dni')) has-error @endif">
            <label for="dni" class="col-sm-3 control-label">DNI *</label>
            <div class="col-sm-9">
                <input type="text" name="dni" id="dni" value="{{ old('dni') }}" class="form-control">
                @if($errors->has('dni'))
                    <span class="help-block">{{$errors->first('dni')}}</span>
                @endif
            </div>
        </div>


        <div class="form-group @if($errors->has('fecha_nacimiento')) has-error @endif">
            <label for="fecha_nacimiento" class="col-sm-3 control-label">Fecha de nacimiento</label>
            <div class="col-sm-9">
                <input type="hidden" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                <input type="text" name="fecha_nacimiento_show" class="form-control">
                {{--        {!! Form::text('fecha_nacimiento', null, ['class' => 'form-control']) !!}--}}
                @if($errors->has('fecha_nacimiento'))
                    <span class="help-block">{{$errors->first('fecha_nacimiento')}}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4 ">

        <img class="img-responsive img-circle"
             src="{{URL::asset('uploads/avatars/'.(isset($agente)?$agente->avatar:\Cat\Models\Agente::$avatar))}}"
             alt="User profile picture"
             style="margin:0 auto;width:150px;"
        >

        <input type="file" name="avatar" id="avatar" style="margin:0 auto;" class="filestyle" data-input="false" accept="image/x-png,image/png,image/gif,image/jpeg" data-buttonName="btn-primary">
    </div>
</div>
<div class="form-group @if($errors->has('cuit')) has-error @endif">
    <label for="cuit" class="col-sm-2 control-label">CUIT *</label>
    <div class="col-sm-8">
        <input type="text" name="cuit" id="cuit" value="{{ old('cuit') }}" class="form-control">
        @if($errors->has('cuit'))
            <span class="help-block">{{$errors->first('cuit')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('email')) has-error @endif">
    <label for="email" class="col-sm-2 control-label">Email *</label>
    <div class="col-sm-8">
        <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control">
        @if($errors->has('email'))
            <span class="help-block">{{$errors->first('email')}}</span>
        @endif
    </div>
</div>
<div class="form-group @if($errors->has('email_gobierno')) has-error @endif">
    <label for="email_gobierno" class="col-sm-2 control-label">Email gobierno</label>
    <div class="col-sm-8">
        <input type="text" name="email_gobierno" id="email_gobierno" value="{{ old('email_gobierno') }}" class="form-control">
        @if($errors->has('email_gobierno'))
            <span class="help-block">{{$errors->first('email_gobierno')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('telefono_particular')) has-error @endif">
    <label for="telefono_particular" class="col-sm-2 control-label">Tel&eacute;fono particular *</label>
    <div class="col-sm-8">
        <input type="text" name="telefono_particular" id="telefono_particular" value="{{ old('telefono_particular') }}" class="form-control">
        @if($errors->has('telefono_particular'))
            <span class="help-block">{{$errors->first('telefono_particular')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('telefono_casa')) has-error @endif">
    <label for="telefono_casa" class="col-sm-2 control-label">Tel&eacute;fono de casa</label>
    <div class="col-sm-8">
        <input type="text" name="telefono_casa" id="telefono_casa" value="{{ old('telefono_casa') }}" class="form-control">
        @if($errors->has('telefono_casa'))
            <span class="help-block">{{$errors->first('telefono_casa')}}</span>
        @endif
    </div>
</div>

<div class="form-group @if($errors->has('telefono_ht')) has-error @endif">
    <label for="telefono_ht" class="col-sm-2 control-label">Tel&eacute;fono HT</label>
    <div class="col-sm-8">
        <input type="text" name="telefono_ht" id="telefono_ht" value="{{ old('telefono_ht') }}" class="form-control">
        @if($errors->has('telefono_ht'))
            <span class="help-block">{{$errors->first('telefono_ht')}}</span>
        @endif
    </div>
</div>


<div class="form-group">
    <label for="estado_civil" class="col-sm-2 control-label">Estado Civil</label>
    <div class="col-sm-8">
        <select name="estado_civil" id="estado_civil" class="form-control">
            @foreach([
             'CASADO'=> 'Casado',
             'SOLTERO' => 'Soltero',
             'VIUDO' => 'Viudo',
             'CONCUBINATO' => 'Concubinato',
             'SEPARADO DE HECHO' => 'Separado de hecho',
             'UNION CIVIL' => 'Uni&oacute;n civil',
             'DIVORCIADO' => 'Divorciado'
              ] as $val => $label)
                <option value="{{ $val }}" {{ old('estado_civil') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="sexo" class="col-sm-2 control-label">Sexo</label>
    <div class="col-sm-8">
        <select name="sexo" id="sexo" class="form-control">
            @foreach([
             'F' => 'Mujer',
             'M' => 'Hombre',
              ] as $val => $label)
                <option value="{{ $val }}" {{ old('sexo') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group @if($errors->has('profesion')) has-error @endif">
    <label for="profesion" class="col-sm-2 control-label">Profesi&oacute;n</label>
    <div class="col-sm-8">
        <input type="text" name="profesion" id="profesion" value="{{ old('profesion') }}" class="form-control">
        @if($errors->has('profesion'))
            <span class="help-block">{{$errors->first('profesion')}}</span>
        @endif
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
    <label for="estudios" class="col-sm-2 control-label">Estudios</label>

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
    <label for="domicilio" class="col-sm-2 control-label">Domicilio *</label>
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


                    <div class="col-sm-2 @if($errors->has("domicilio.codigo_postal.$control" )) has-error @endif">
                        <input type="text" class="form-control" value="{{$dom['codigo_postal']}}"
                               placeholder="C&oacute;digo postal"
                               name="domicilio[codigo_postal][]">
                        @if($errors->has("domicilio.codigo_postal.$control"))
                            <span class="help-block">{{$errors->first("domicilio.codigo_postal.$control")}}</span>
                        @endif
                    </div>


                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{$dom['libre']}}" placeholder="Otro"
                               name="domicilio[libre][]">
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
                        <input type="hidden" name="domicilio[constituido][]"
                               value="{{$dom['constituido']== true ?1:0}}"/>
                    </div>
                </div>
                <hr>
            </div>
        @endforeach
    </div>
</div>

<div class="form-group @if($errors->has('observacion')) has-error @endif">
    <label for="observacion" class="col-sm-2 control-label">Observaci&oacute;n</label>
    <div class="col-sm-8">
        <textarea name="observacion" id="observacion" class="form-control">{{ old('observacion') }}</textarea>
        @if($errors->has('observacion'))
            <span class="help-block">{{$errors->first('observacion')}}</span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Siguiente</button>
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

            var im = new Inputmask("99-99999999-9");
            im.mask('input[name="cuit"]');

            // Alineacion de  la imagen y el seleccionar archivo
            $('.bootstrap-filestyle').prop('style', 'margin: 0px auto')
        });

    </script>

@append
