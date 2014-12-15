<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 28/11/14
 * Time: 16:02
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$busqueda = new tratamientosVencen();

		$response['status'] = 'OK';

		$response['datos'] = $busqueda->traerResultados();

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);