<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 19/11/14
 * Time: 16:33
 */

include_once 'objects/Tratamiento.php';
include_once 'util.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){
		$data = get_post();

		$idTrat = $data['idtrat'];

		$tratamiento = new Tratamiento();
		$tratamiento->porId($idTrat);

		if ($tratamiento->darDeAlta()){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}
		$response['datos'] = $tratamiento;

	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);