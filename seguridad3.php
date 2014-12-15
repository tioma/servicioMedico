<?php

include_once 'loginseg.php';
include_once 'bd.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);

if ($_POST['usuario'] <> '')
{
	if (isset($_POST['parametros']) && $_POST['parametros'] == 'on') $parametros='TRUE'; else $parametros='FALSE';
	if (isset($_POST['tratamientos']) && $_POST['tratamientos'] == 'on') $tratamientos='TRUE'; else $tratamientos='FALSE';
	if (isset($_POST['listados']) && $_POST['listados'] == 'on') $listados='TRUE'; else $listados='FALSE';
	$query = "select * from habagp.permisosmed where usuario like '".$_POST['usuario']."'";
	$unaBD = new bd();
	$unaBD->conectar();
	$unaBD->consultar($query);
	if ($unaBD->cantidad == 0)
		$ActualizaUsuario = "Insert into habagp.permisosmed values ('" . $_POST['usuario'] . "','" . $parametros . "','" . $tratamientos . "','" . $listados . "')";
	else
		$ActualizaUsuario = "Update habagp.permisosmed set parametros='" . $parametros . "',tratamientos='" . $tratamientos . "',listados='" . $listados . "' where usuario='" . $_POST['usuario'] . "'";
	$unaBD->consultar($ActualizaUsuario);
	$unaBD->cerrarConexion();
	header("Location: seguridad.php?result=1");
	exit;
}
else
{
	header("Location: seguridad.php?result=2");
	exit;
}
?>