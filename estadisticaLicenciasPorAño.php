<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("listados");
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
    <tr align="center">
    	<td colspan="2" align="center">
    		<form id="frmListado" action="licenciasPorA&ntilde;o.php" method="post">
			<table>
				<tr align="center">
                	<td colspan="2"><strong>Promedio de d&iacute;as por tipo de licencia</strong></td>
                </tr>
    			<tr>
					<td colspan="4">
						Desde:
      					<select name="sel_inicio" id="sel_inicio">
      					<?php 
      						$año = date("Y");
      						for ($i = 1943; $i <= $año; $i++){
      							echo '<option value="' . $i . '" >' . $i . '</option>';
      						}
      					?> 
            			</select>
            			 - Hasta: 
      					<select name="sel_final" id="sel_final">
      					<?php 
      						$año = date("Y");
      						for ($i = 1943; $i <= $año; $i++){
      							echo '<option value="' . $i . '" >' . $i . '</option>';
      						}
      					?> 
            			</select>
					</td>			
				</tr>
				<tr>
					<td align="center">
						<button type="button" value="listado" onclick="confirmoListado(document.getElementById('sel_inicio').value, document.getElementById('sel_final').value)" ><img src="./img/report.png" alt="" />Generar</button>
					</td>
				</tr>
			</table>
			</form>
		</td>    	
	</tr>
	<tr>
		<td colspan="2" align="right" height="60">
			<hr/><dfn>Administraci&oacute;n General de Puertos S.E. - AGP<img src="img/AGP.JPG" width="20" height="23" /></dfn>
		</td>
	</tr>
</table>
</div>
<p>&nbsp;</p>
</body>
</html>