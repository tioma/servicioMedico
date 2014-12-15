<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 03/12/14
 * Time: 14:45
 */

include_once 'util.php';
include_once 'objects/Usuario.php';

session_start();

if (isset($_SESSION['permisos']['parametros'])){
	if ($_SESSION['permisos']['parametros']){

		$data = get_post();

		$usuario = new Usuario();

		$usuario->setNombre($data['usuario']);

		if ($usuario->eliminar()){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}
	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
}

send_response($response);