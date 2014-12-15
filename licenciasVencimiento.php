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
    <tr>
    	<td colspan="2" align="center">
    		<form method="post" id="frm_principal" action="excelVencimiento.php">
		    <table>
			    <tr>
			    	<td align="center"><strong>Visualizaci&oacute;n de licencias cercanas al vencimiento</strong></td>
			    </tr>
				<tr>
					<td align="center">
						<input type="text" size="50" class="guardar_datos" name="dias_vencimiento" id="dias_vencimiento" autocomplete="off" value="Ingrese d&iacute;as restantes"/>
						<button type="button" id="vencimiento"><img src="./img/report.png" alt="" />Generar</button>
						<button type="button" id="aExcel"><img src="./img/page_excel.png" alt="" />Exportar</button>
						<div id="cargando" style="display: none"><img src="img/ajax-loader.gif"/></div>
					</td>
				</tr>
				<tr>
					<td align="center"><div id="divLicencias" style="width: 100%; height: 100%px; overflow: auto;"></div></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="2" >
			<hr />
			<p align="right"><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn></p>
			<p></p>	
		</td>
	</tr>
</table>
</div>
</body>
</html>