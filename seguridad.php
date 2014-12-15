<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);

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
		<td align="center" colspan="2">
			<form method="post" action="seguridad2.php">
				<table>
					<tr>
						<td align="center" colspan="2"><strong>Usuarios</strong></td>
					</tr>
					<tr>
						<td align="right">
							<select name="musuario"><option>Usuario</option>
								<?php
								$query = 'select usuario from habagp.permisosmed order by usuario';
								$unaBD = new bd();
								$unaBD->conectar();
								$unaBD->consultar($query);
								$unaBD->cerrarConexion();
								while ($rowEmp = pg_fetch_assoc($unaBD->datos))
									echo '<option>'.$rowEmp['usuario'].'</option>';
								?>
							</select>
						</td>
						<td align="left">
							<button type="submit" name="btnModificar" value="Modificar"><img src="img/group_edit.png"/><b> Modificar usuario</b></button>
						</td>
					</tr>
					<tr>
						<td align="right">
							<input type="text" name="nusuario" value="" size="15"/>
						</td>
						<td align="left">
							<button type="submit" name="btnNuevo" value="Nuevo"><img src="img/group_add.png"/><b> Nuevo usuario</b></button>
						</td>
					</tr>
				</table>
			</form>
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