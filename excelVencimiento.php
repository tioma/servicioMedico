<?php

include_once 'loginseg.php';
include_once 'busquedas.php';

$validacion = new validoUsuario("listados");
$validacion->validar($_SESSION['permisos']);

$licencias = new buscarLicenciasAcumuladas();

$dias = $_POST['dias_vencimiento'];

if ($dias != "Ingrese días restantes" && $dias != ""){
	$licencias->porDiasRestantes($dias);	
}

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");  
header ("Content-type: application/x-msexcel");  
header ("Content-Disposition: attachment; filename=\"vencimientos.xls\"");

echo utf8_decode($licencias->traerResultados());

?>