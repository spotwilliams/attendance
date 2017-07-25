@foreach($agentes as $agente)
    <tr>
        <td>{{$agente->nombre}}, {{$agente->apellido}}</td>
        <td>{{$agente->cuit}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','base','nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','turno','codigo'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','area','nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','tipoContrato','descripcion'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','fecha_ingreso'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','cargo', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','funcion', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','estadoContrato', 'descripcion'])}}</td>
    </tr>
@endforeach