<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 14/11/14
 * Time: 16:07
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$tratamiento = get_post();

		$busqueda = new buscarEvolucion();

		$response['status'] = 'OK';
		$response['datos'] = $busqueda->evolucionTratamiento($tratamiento['idtrat']);
	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);