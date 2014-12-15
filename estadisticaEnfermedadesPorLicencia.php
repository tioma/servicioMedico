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
    		<form id="frmListado" action="rankingEnfermedadesPorLicencia.php" method="post">
			<table>
				<tr align="center">
                	<td colspan="2"><strong>Ranking de enfermedades por tipo de licencia</strong></td>
                </tr>
				<tr>
					<td colspan="4">Tipo de licencia
        				<select name="tipo_licencia" id="tipo_licencia"> 
            				<option value="CT" >CT - Corto tratamiento</option>
                			<option value="LT" >LT - Largo tratamiento</option>
                			<option value="MA" >MA - Maternidad</option>
                			<option value="A17G" >A17G - Art&iacute;culo 17 con goce</option>
                			<option value="A17S" >A17S - Art&iacute;culo 17 sin goce</option>
                			<option value="ART9" >ART9 - Art&iacute;culo 9 (Paternidad)</option>
                			<option value="ACC" >ACC - Accidente</option>
            			</select>
    				</td>				
				</tr>
				<tr>
			    	<td colspan="4">L&iacute;mite
    					<select name="sel_limite" id="estado_licencia"> 
            				<option value="3" >Top 3</option>
                			<option value="5" >Top 5</option>
                			<option value="10" >Top 10</option>
            			</select>
    				</td>
    			</tr>
    			<tr>
					<td colspan="4">
						Desde:
						<label>
        				<input type="text" name="txt_inicio" id="txt_inicio" />
      					</label>
      					<input type="button"  id="btn_inicio" value="..." />
      					<script type="text/javascript">
      						Calendar.setup({
       							button	   : "btn_inicio",
								inputField : "txt_inicio",
        						trigger    : "btn_inicio",
        						onSelect   : function() { this.hide(); },
        						showTime   : 24,
        						dateFormat : "%Y-%m-%d"
      						});
    					 </script>
					</td>			
				</tr>
				<tr>
					<td colspan="4" >
						Hasta: 
						<label>
        				<input type="text" name="txt_hasta" id="txt_hasta" />
      					</label>
      					<input type="button"  id="btn_hasta" value="..." />
      					<script type="text/javascript">
      						Calendar.setup({
       							button	   : "btn_hasta",
								inputField : "txt_hasta",
        						trigger    : "btn_hasta",
        						onSelect   : function() { this.hide(); },
        						showTime   : 24,
        						dateFormat : "%Y-%m-%d"
      						});
    					 </script>
					</td>			
				</tr>
				<tr>
					<td align="center">
						<button type="button" value="listado" onclick="document.getElementById('frmListado').submit();" ><img src="./img/report.png" alt="" />Generar</button>
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