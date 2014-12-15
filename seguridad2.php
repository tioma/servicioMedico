<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);

if (isset($_POST['btnModificar']) && $_POST['musuario'] !== 'Usuario')
{
	$query = "select parametros, tratamientos, listados from habagp.permisosmed where usuario like '".$_POST['musuario']."'";
	$unaBD = new bd();
	$unaBD->conectar();
	$unaBD->consultar($query);
	$unaBD->cerrarConexion();
	
	$rowEmp = pg_fetch_assoc($unaBD->datos);
}

if (isset($_POST['btnModificar']) && $_POST['musuario'] == 'Usuario' || isset($_POST['btnNuevo']) && $_POST['nusuario'] == '')
{
	header("Location: seguridad.php");
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Servicio M&eacute;dico</title>
<link rel="Shortcut Icon" href="imagenes/group_edit.png"/> 
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="blue-menu.files/dmenu.js"></script>
</head>
<body>
<br /> <br />
<form name="form1" method="post" action="seguridad3.php">
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
	<tr align="center">
		<td align="center" colspan="2" height="50" class="EstiloTitulo">Usuarios</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Usuario: <?php if ($_POST['nusuario'] !== '') echo $_POST['nusuario']; else echo $_POST['musuario']; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center">Parametros
				<?php if ($rowEmp['parametros'] == 't'): ?>
					<input type="checkbox" name="parametros" checked="checked"/>
				<?php else: ?>
					<input type="checkbox" name="parametros"/>
				<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Tratamientos
				<?php if ($rowEmp['tratamientos'] == 't'): ?>
					<input type="checkbox" name="tratamientos" checked="checked"/>
				<?php else: ?>
					<input type="checkbox" name="tratamientos"/>
				<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Listados
				<?php if ($rowEmp['listados'] == 't'): ?>
					<input type="checkbox" name="listados" checked="checked"/>
				<?php else: ?>
					<input type="checkbox" name="listados"/>
				<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2" height="50"><button type="submit" name="btnActualizar" value="Actualizar"><img src="img/arrow_rotate_clockwise.png"/><b> Actualizar</b></button></td>
	</tr>
	<tr>
		<td colspan="2"><input type="hidden" name="usuario" value="<?php if ($_POST['nusuario'] !== '') echo $_POST['nusuario']; else echo $_POST['musuario']; ?>" /></td>
	</tr>
	<tr>
		<td align="right" height="60" colspan="2">
			<hr/><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn>
		</td>
	</tr>
</table>
</div>
</form>
</body>
</html>