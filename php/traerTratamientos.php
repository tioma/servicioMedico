<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 12/11/14
 * Time: 16:16
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){

		$data = get_post();

		$busqueda = new buscarTratamiento();

		$totalRegistros = $busqueda->cantidadRegistros($data['filtros']);

		$busqueda->ponerFiltros($data['filtros'], $data['pagina']);
		$datos = $busqueda->traerResultados();

		$response['status'] = 'OK';
		$response['totalRegistros'] = $totalRegistros;
		$response['datos'] = $datos;

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);

