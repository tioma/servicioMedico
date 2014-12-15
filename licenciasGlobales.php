<?php
include_once 'loginseg.php';
include_once 'validaUsuario.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<title>Sistema de Servicio M&eacute;dico</title>
<script src="JSCal2-1.9/src/js/jscal2.js"></script>
<script src="JSCal2-1.9/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/steel/steel.css" />
<script type="text/javascript" src="./jBusquedas.js"></script>
<script type="text/javascript" src="./jFechas.js"></script>
<script type="text/javascript" src="./jquery.js"></script>
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
    <tr>
		<td colspan="2" align="center" >
			<br/>
			<form id="frmPrincipal" method="post" action="php/actualizarLicencia.php">
			<table>
				<tr align="center">
                	<td colspan="2"><strong>Actualizaci&oacute;n de licencias</strong></td>
                </tr>
				<tr align="center">
					<td colspan="2" align="center">Empleado: 
						<input type="text" size="50" name="persona" class="id_busqueda guardar_datos" id="id_busqueda_persona" autocomplete="off" value="Ingrese Legajo o Apellido y Nombre"/>
						<div class="div_busqueda oculto" id="div_busqueda_persona" style="width: 100%; height: 100px; overflow: auto;"></div>
						<button type="button" id="btn_mostrar" value="Mostrar" >Mostrar</button>
					</td>
				</tr>
				<tr>
					<td>
						<div id="datos_licencia">
						</div>
					</td>
				</tr>
			</table>
			</form>    
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