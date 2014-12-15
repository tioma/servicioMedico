<?php
include_once 'loginseg.php';
include_once 'validaUsuario.php';
include_once 'busquedas.php';

$validacion = new validoUsuario("tratamientos");
$validacion->validar($_SESSION['permisos']);

$todasLasLicencias = new tiposDeLicencias();
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
			<form id="frmPrincipal" method="post" action="crearTratamiento.php">
			<table>
				<tr align="center">
                	<td colspan="2"><strong>Ficha de tratamientos</strong></td>
                </tr>
				<tr align="center">
					<td colspan="2" align="center">Empleado: 
						<input type="text" size="50" name="persona" class="id_busqueda guardar_datos" id="id_busqueda_persona" autocomplete="off" value="Ingrese Legajo o Apellido y Nombre"/>
						<div class="div_busqueda oculto" id="div_busqueda_persona" style="width: 100%; height: 100px; overflow: auto;"></div>
						<div class="txtHint estiloAvisoError" id="txtHint"></div>
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">Tipo de licencia 
						<select name="tipo_licencia" id="tipo_licencia" onclick="escondoEnfermedad()"> 
                  			<?php echo $todasLasLicencias->traerResultados(); ?>  		
                    	</select>
					</td>
				</tr>
				<tr align="center">
					<td colspan="2"><div id="enfermedad">Enfermedad: 
						<input type="text" size="50" name="codigoEnf" class="id_busqueda guardar_datos" id="id_enfermedad" autocomplete="off" value="Ingrese Codigo de Enfermedad o Enfermedad"/>
						<div class="div_busqueda oculto" id="busqueda_enfermedad" style= "width: 100%; height: 100%; overflow: auto;"></div>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center">
						<strong>Fecha inicio: </strong>
						<label>
        				<input type="text" name="txt_inicio" id="txt_inicio" value="<?php echo date("Y-m-d"); ?>"/>
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
     				<td align="center">
     					<div id="dias_otorgados">
     					<strong>D&iacute;as otorgados: </strong>
     					<input type="text" name="txt_diasExtra" id="txt_diasExtra" onkeyup="calculoAlta2(this.value)"/>
     					</div>
     				</td>
				</tr>
				<tr>
					<td align="center">
						<div id="fecha_alta">
						<strong>Fecha alta: </strong>
						<label>
        				<input type="text" name="txt_alta" id="txt_alta" />
        				<input name="f_alta" type="hidden" />
      					</label>
      					<input type="button"  id="btn_alta" value="..." />
      					<script type="text/javascript">
      						Calendar.setup({
       							button	   : "btn_alta",
								inputField : "txt_alta",
        						trigger    : "btn_alta",
        						onSelect   : function() { this.hide(); calculoDiasOtorgados(document.getElementById("txt_alta").value);},
        						showTime   : 24,
        						dateFormat : "%Y-%m-%d"
      						});
    					</script>
    					</div> 	
					</td>
					<td align="center">
						<div id="estado_lic">
						<strong>Estado de la licencia</strong> 
                    	<select name="estado_licencia" id="estado_licencia"> 
                    		<option value="C" >Con licencia</option>
                        	<option value="A" >De alta</option>
                    	</select>
                    	</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" valign="middle">Descripci&oacute;n - 
						<textarea name="descripcion_trat" id="descripcion_trat"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="button" id="btn_guardar" value="Guardar" onclick='calculoAlta2(document.getElementById("txt_diasExtra").value); validarNuevoTratamiento()'/>
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