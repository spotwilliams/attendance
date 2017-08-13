@foreach($agentes as $agente)
    <tr>
        <td>{{$agente->nombre}}, {{$agente->apellido}}</td>
        <td>{{$agente->cuit}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','base', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','turno', 'codigo'])}}</td>
{{--        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','area', 'nombre'])}}</td>--}}
{{--        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','tipoContrato', 'descripcion'])}}</td>--}}
        <?php
        $presentismos = $agente->presentismos->keyBy('fecha');
        ?>
        @foreach($presentismos as $p)
            <td>
                {!! $p->tipoPresentismo->getMyLabel() !!}
                <br>
                @if($p->injustificado == true)
                    <label class="label label-danger">Injustificado</label>
                @else
                    <label class="label label-info">Justificado</label>
                @endif
            </td>
        @endforeach
    </tr>
@endforeach