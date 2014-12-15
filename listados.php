<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("listados");
$validacion->validar($_SESSION['permisos']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Servicio M&eacute;dico</title>
<link rel="Shortcut Icon" href="imagenes/group_edit.png"/> 
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="./jquery.js"></script>
<script type="text/javascript" src="./jBusquedas.js"></script>
<script type="text/javascript" src="./jQueryEnfermedad.js"></script>
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
    	<td colspan="2" align="center">
		    <table style= "width:100%;">
			    <tr>
			    	<td align="center">
			    		<strong>Visualizaci&oacute;n de licencias acumuladas</strong>
			    	</td>
			    </tr>
				<tr>
					<td align="center" >
						<input type="text" size="50" name="licenciasAcumuladas" id="licenciasAcumuladas" class="id_busqueda_sin_ocultar guardar_datos cargar_tabla_sin_filtro" autocomplete="off" value="Ingrese Legajo o Apellido y Nombre"/>
						<div class="div_busqueda" id="divLicenciasAcumuladas" style= "width: 100%; height: 200px;  overflow: auto;"></div>
						<div class="txtHint" class="estiloAvisoError" style= "width:100%; height: 100%; "></div>
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="radio" class="licenciasA" value="licenciasAcumuladas" name="licenciasA" checked="checked" />Licencias acumuladas
						<input type="radio" class="licenciasA" name="licenciasA" value="otrasLicencias" />Otras Licencias
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<hr />
			<p align="right"><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn></p>
			<p></p>	
		</td>
	</tr>
</table>
</div>
</body>
</html>