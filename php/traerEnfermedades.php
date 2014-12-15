<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 13/11/14
 * Time: 11:36
 */

include_once 'objects/busquedas.php';
include_once 'util.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$busqueda = new buscarEnfermedad();

		$response['status'] = 'OK';
		$response['datos'] = $busqueda->traerResultados();

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);