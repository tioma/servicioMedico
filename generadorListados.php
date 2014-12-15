<?php

include_once 'loginseg.php';
include_once 'busquedas.php';

$validacion = new validoUsuario("listados");
$validacion->validar($_SESSION['permisos']);

$todasLasLicencias = new tiposDeLicencias();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<title>Sistema de Servicio M&eacute;dico</title>
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
    		<form id="frmListado" action="mostrarListado.php" method="post">
			<table>
				<tr align="center">
                	<td colspan="2"><strong>Generador de listados</strong></td>
                </tr>
				<tr align="center">
					<td colspan="4">Empleado: 
						<input type="text" size="50" name="persona" class="id_busqueda guardar_datos" id="id_busqueda_persona" autocomplete="off" value="Ingrese Legajo o Apellido y Nombre"/>
						<div class="div_busqueda oculto" id="div_busqueda_persona" style="width: 100%; height: 100%; overflow: auto;"></div>
					</td>
				</tr>
				<tr>
					<td colspan="4">Tipo de licencia
        				<select name="tipo_licencia" id="tipo_licencia"> 
            				<?php echo $todasLasLicencias->traerResultados(); ?>
                			<option value="Todos" >Todos los tipos</option>
            			</select>
    				</td>				
				</tr>
				<tr>
			    	<td colspan="4">Estado de la licencia 
    					<select name="estado_licencia" id="estado_licencia"> 
            				<option value="A" >De alta</option>
                			<option value="C" >Con licencia</option>
                			<option value="D" >Ambas</option>
            			</select>
    				</td>
    			</tr>
    			<tr>
					<td colspan="4">Ordenar por 
        				<select name="orden" id="orden"> 
            				<option value="nombre" >Nombre</option>
                			<option value="nro_legajo" >Legajo</option>
                			<option value="fechaini" >Fecha de inicio</option>
                			<option value="fechaalta" >Fecha de alta</option>
                			<option value="tipolic" >Tipo de licencia</option>
                			<option value="est.descripcion" >Estado de licencia</option>
            			</select>
    				</td>				
				</tr>
				<tr>
					<td>
						<button type="button" value="listado" onclick="opcionListado(this.value)"><img src="./img/report.png" alt="" />Generar</button>
						<button type="button" value="excel" onclick="opcionListado(this.value)"><img src="./img/page_excel.png" alt="" />Exportar</button>
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