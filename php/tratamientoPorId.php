<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 02/12/14
 * Time: 11:14
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$idTrat = get_post();

		$busqueda = new buscarTratamiento();

		$datos = $busqueda->porID($idTrat);

		$response['status'] = 'OK';
		$response['datos'] = $datos;

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);