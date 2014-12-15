<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 05/12/14
 * Time: 15:49
 */

include_once 'objects/Enfermedad.php';
include_once 'util.php';

session_start();

if (isset($_SESSION['permisos']['parametros'])){
	if ($_SESSION['permisos']['parametros']){

		$data = get_post();

		$enfermedad = new Enfermedad();

		$enfermedad->setCodEnfermedad($data['codigo']);
		$enfermedad->setDescripEnfermedad($data['enfermedad']);

		if ($enfermedad->modificaEnfermedad()){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}

		$response['datos'] = $enfermedad;
	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);