@foreach($agentes as $agente)
    <tr>
        <td>{{$agente->nombre}}, {{$agente->apellido}}</td>
        <td>{{$agente->cuit}}</td>
        <td>{{$agente->dni}}</td>
        <td>{{$agente->email}}</td>
        <td>{{$agente->telefono}}</td>
        <td>
            @if($agente->domicilios != null)
                @foreach($agente->domicilios as $dom)
                    {{$dom->printMe()}}
                @endforeach
            @endif
        </td>
        <td>
            @if($agente->estudio != null)
                @foreach($agente->estudio as $est)
                    {{$est->printMe()}}
                @endforeach
            @endif
        </td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['fecha_nacimiento'],
        function($fecha){
                return (new \DateTime($fecha))->format('d/m/Y');
            }
            )}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','id_sial'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','ficha'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','tipoContrato','descripcion'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','fecha_ingreso'],
        function($fecha){
                return (new \DateTime($fecha))->format('d/m/Y');
            }
            )}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','fecha_ingreso_gobierno'],
        function($fecha){
                return (new \DateTime($fecha))->format('d/m/Y');
            })}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','tipo_inscripcion'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','estadoContrato', 'descripcion'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','base','nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','gerencia','nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','area','nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','cargo', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','funcion', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','funcion_especifica'])}}</td>

        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','turno', 'codigo'])}}</td>
        <td>
            {{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','horario', 'hora_entrada'])}}
            a
            {{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','horario', 'hora_entrada'])}}
        </td>

        <td>
            {{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','horario', 'rotativo'],
            function($rotativo){
                return ($rotativo==true)? 'SI': 'NO';
            })}}
        </td>
        <td>
            {{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','horario', 'eximido'],
            function($eximido){
                return ($eximido==true)? 'SI': 'NO';
            })}}
        </td>
    </tr>
@endforeach