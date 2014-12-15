<?php

include_once 'objects/Empleado.php';
include_once 'util.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$data = get_post();

		$empleado = new Empleado(trim($data['legajo']), $data['nombre']);

		$empleado->setDiasAcum($data['diasacum']);

		if ($empleado->actualizarCabecera(0, $data['ultausencia'])){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}

		$response['datos'] = $empleado;

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);



