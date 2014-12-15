<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("tratamientos");
$validacion->validar($_SESSION['permisos']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<title>Sistema de Servicio M&eacute;dico</title>
<script type="text/javascript" src="./jBusquedas.js"></script>
<script type="text/javascript" src="blue-menu.files/dmenu.js"></script>
</head>
<body onload="cargaInicial()">
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
    	<td align="center" colspan="2">
    		<br/>
    		<form name="filtros">
    			<a href="./maestroTratamientosAlta.php"  style="text-decoration: none;" ><input type="button" value="Nuevo tratamiento" /></a>
    			<input name="filtro" type="radio" value="Alta" /> Solo Altas
            	<input name="filtro" type="radio" value="Curso" /> Solo En Curso
            	<input name="filtro" type="radio" value="Ambas" checked="checked" /> Todos
            	<input name="boton" type="button" value="Filtrar" onclick="traerTabla('0', 'nada')"/>
            </form>
    	</td>
    </tr>
    <tr>
		<td colspan="2">
			<table>
				<tr align="center">
					<td> Por nombre o legajo <input class="cajaBusqueda" type="text" name="nombre" onkeyup="traerTabla(this.value, 'nombre')"/></td>
					<td> Por enfermedad <input class="cajaBusqueda" type="text" name="enfermedad" onkeyup="traerTabla(this.value, 'enfermedad')" /></td>
					<td> Por fecha de incio <input class="cajaBusqueda" type="text" name="inicio" onkeyup="traerTabla(this.value, 'inicio')"/></td>
					<td> Por fecha de alta <input class="cajaBusqueda" type="text" name="alta" onkeyup="traerTabla(this.value, 'alta')" /></td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<hr />
						<div id="txtHint" style= "width:100%; height: 350px; overflow: auto;" ></div>
					</td>
				</tr>
			</table>
		</td>    
    </tr>
	<tr>
		<td align="right" height="60" colspan="2">
			<hr/><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn>
		</td>
	</tr>
</table>
</div>
<p>&nbsp;</p>
</body>
</html>

