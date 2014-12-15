<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 02/12/14
 * Time: 15:24
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['parametros'])){
	if ($_SESSION['permisos']['parametros']){

		$busqueda = new buscarUsuarios();

		$datos = $busqueda->traerResultados();

		$response['status'] = 'OK';
		$response['datos'] = $datos;

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);
