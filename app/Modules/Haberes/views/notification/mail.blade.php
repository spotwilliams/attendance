<h3>Haberes</h3>

<div>
    Estimado, de acuerdo a las asistencias y ausencias correspondientes
    al periodo de {{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}} hasta {{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}, usted debe presentar una factura por el monto de $ {{$data['monto']}}.

    Se han registrado {{$data['faltas']}} faltas no justificadas.

    Atte.-
</div>
