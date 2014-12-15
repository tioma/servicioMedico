<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 09/12/14
 * Time: 12:20
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$data = get_post();

		$busqueda = new generaListados();

		$busqueda->ponerFiltros($data);
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