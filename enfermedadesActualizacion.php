<?php

include_once 'loginseg.php';
include_once 'Enfermedad.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);

$codigoEnf = $_POST['campo_codigo'];
$descripEnf = $_POST['campo_enfermedad'];
$tipoCambio = $_POST['TipoCambio'];

if (isset($codigoEnf) && $codigoEnf != '' && isset($descripEnf) && $descripEnf != '' && isset($tipoCambio) && $tipoCambio != ''){

	$enfermedad = new Enfermedad();
	$enfermedad->setCodEnfermedad($codigoEnf);
	$enfermedad->setDescripEnfermedad($descripEnf);
	
	switch($tipoCambio){
		case 'Nuevo':
			$enfermedad->nuevaEnfermedad();
			break;
		case 'Modificar':
			$enfermedad->modificaEnfermedad();
			break;
		case 'Eliminar':
			$enfermedad->eliminaEnfermedad();
			break;
	}
};
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="blue-menu.files/dmenu.js"></script>
<title>Sistema de Servicio M&eacute;dico</title>
</head>
<body>
<br /> <br />
<div class="TablaPrincipal">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" height="15px" bgcolor="#C0D7E8"></td>
	</tr>
	<tr>
		<td align="center" height="33px" valign="top" style="background: url(blue-menu.files/normal_back.png) repeat-x">
			<img src="img/minilogo.png" height="33" width="130"/>
		</td>
		<td align="center" height="33px" valign="top" style="background: url(blue-menu.files/normal_back.png) repeat-x">
			<?php include "menu.php"; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="10px" bgcolor="#649DC8" style='font-size: 1px;'></td>
	</tr>
	<tr>
		<td colspan="2" align="center" height="50px">
			<?php if($enfermedad->mensajeError == ''): ?>
			La operaci&oacute;n se ha realizado correctamente
			<?php else: ?>
			<img src="img/stop.ico" height="20" width="20" /><?php echo $enfermedad->mensajeError; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td align="right" height="60" colspan="2">
			<hr/><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn>
		</td>
	</tr>
</table>
</div>
</body>
</html>