<?php

include_once 'loginseg.php';
include_once 'busquedas.php';

$validacion = new validoUsuario("listados");
$validacion->validar($_SESSION['permisos']);

$tratamiento = new generaListados();

if ($_POST['persona'] != "Ingrese Legajo o Apellido y Nombre"){
	$datosPersona=split("-", $_POST['persona']);
	$legajo = trim($datosPersona[0]);
	$tratamiento->porNombre($legajo);	
}

if ($_POST['tipo_licencia'] != "Todos"){
	$tratamiento->tipoLicencia($_POST['tipo_licencia']);	
}

switch ($_POST['estado_licencia']){
	case "A":
		$tratamiento->soloAltas();
		break;
	case "C":
		$tratamiento->soloEnCurso();
		break;
}

$tratamiento->conOrden($_POST['orden']);

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header ("Content-type: application/x-msexcel");  
header ("Content-Disposition: attachment; filename=\"listado.xls\"");

echo utf8_decode($tratamiento->generoExcel());

?>