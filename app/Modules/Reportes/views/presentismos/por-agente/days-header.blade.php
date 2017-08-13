
<th>Personal</th>
<th>CUIT</th>
<th>Base</th>
<th>Turno</th>
<th>&Aacute;rea</th>
<th>Tipo de contrato</th>

<?php
$presentismos = $agentes->get(0)->presentismos->keyBy('fecha');
?>
@foreach($presentismos as $p)
    <th>{!! (new DateTime($p->fecha))->format('d/m') !!}</th>
@endforeach
