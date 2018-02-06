<?php

/** @var array $fechasToShow */
if (isset($desde) and isset($hasta)) {
    $fechasToShow = \Cat\Helpers\Calculation::getAllDaysBetween($desde, $hasta);
} else {
    $fechasToShow = [];
}

?>
<th></th>
<th>Personal</th>
<th>CUIT</th>
<th>Base</th>
<th>Turno</th>
<th>&Aacute;rea</th>
<th>Tipo de contrato</th>

@for($i = 0; $i < count($fechasToShow) ;$i++)
    <th>{{(new DateTime($fechasToShow[$i]))->format('d/m/y')}}</th>
@endfor
