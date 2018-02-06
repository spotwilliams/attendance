@foreach($agentes as $agente)
    <tr>
        <td><a href="{{route('agentesShow', ['id' => $agente->id])}}" data-toggle="popover" title="Ver datos" data-content="Abre la ficha del agente en otra pesta&ntilde;a" target="_blank" class="label label-success"><i class="fa fa-eye"></i></a></td>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        })
    </script>
@append