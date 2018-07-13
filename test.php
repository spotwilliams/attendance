<?php
require __DIR__.'/bootstrap/autoload.php';

$fecha = new DateTime('2018-02-05');

dd($fecha->diff(new DateTime('now')));
//echo $fecha->format('d-m-Y');