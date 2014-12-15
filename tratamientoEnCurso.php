<?php

include_once 'Empleado.php';

$datos_empleado = split("-", $_REQUEST['empleado']);

$empleado = new Empleado($datos_empleado[0], $datos_empleado[1]);

if ($empleado->tieneTratamientoEnCurso()){
	echo "El usuario seleccionado ya posee un tratamiento en curso.<br/>";
	echo 'Presione <a href="fichaTratamiento.php?id=' . $empleado->tratamientoEnCurso . '" >aqu&iacute;</a> para verlo.';
}

?>