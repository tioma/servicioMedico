<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 11/11/14
 * Time: 17:14
 */

include_once 'util.php';
include_once 'objects/bd.php';

$data = get_post();

$user = $data['email'];
$pass = $data['password'];

$ldapconn = ldap_connect('10.0.0.56',389) or die("No se pudo conectar con el servidor LDAP.");

ldap_set_option($ldapconn,LDAP_OPT_PROTOCOL_VERSION,3) or die("No se pudo establecer la versión del protocolo LDAP");

$credencial = $user . '@ptobaires.gov.ar';

try {
	if (!@ldap_bind($ldapconn, $credencial, $pass)){
		ldap_unbind($ldapconn);
		$response['status'] = 'ERROR';
	}
	else {
		$unaBD = new bd();
		$query = "SELECT * FROM habagp.permisosmed WHERE usuario = '" . $user . "'";

		$unaBD->conectar();
		$unaBD->consultar($query);
		$unaBD->cerrarConexion();

		if ($unaBD->cantidad > 0)
		{
			session_start();
			$_SESSION['permisos'] = $unaBD->datos[0];
			$response['status'] = 'OK';
			$data['permisos'] = $unaBD->datos[0];
		}
		else {
			ldap_unbind($ldapconn);
			$response['status'] = 'ERROR';
		}
	}

	$response['data'] = $data;
	$_SESSION['id'] = $user;
	$_SESSION['password'] = $pass;

} catch (Exception $e){
	$response['status'] = 'ERROR';
}

send_response($response);