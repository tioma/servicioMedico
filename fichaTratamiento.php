<?php

include "loginseg.php";
include_once 'Tratamiento.php';
include_once 'busquedas.php';

$validacion = new validoUsuario("tratamientos");
$validacion->validar($_SESSION['permisos']);

$idtrat = $_GET['id'];

$tratamiento = new Tratamiento();
$tratamiento->porId($idtrat);

$fecha_inicio = new DateTime($tratamiento->fechaInicio);
$fecha_hoy = new DateTime(date("Y-m-d"));

$dias_transcurridos = $fecha_inicio->diff($fecha_hoy);

$habilitar_form = "";
if (trim($tratamiento->estado) == 'De Alta'){
	$habilitar_form = 'disabled="disabled"';
}

$eliminar = "";
if (!$tratamiento->puedoEliminar()){
	$eliminar = 'disabled="disabled"';
}

$selectLicencias = new licenciasEnTratamiento($tratamiento);

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
<body onload="traerEvolucion(<?php echo $idtrat; ?>); escondoEnfermedad();">
<form id="frmPrincipal" action="php/guardarTratamiento.php" method="post" >
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
			<table>
				<tr align="center">
                	<td colspan="4">
                	<strong>Ficha de tratamientos</strong>
                	</td>
                </tr>
                <tr align="center">
                	<td colspan="4">Tratamiento Nº: <?php echo $idtrat; ?><input name="id_trat" id="id_trat" type="hidden" value="<?php echo $idtrat; ?>" /></td>
				</tr>
				<tr align="center">
                 	<td colspan="4">Legajo: <?php echo $tratamiento->empleado->legajo; ?> - Nombre completo: <?php echo $tratamiento->empleado->nombre; ?>
                    </td>
				</tr>
				<tr align="center">
                 	<td colspan="4">Tipo de licencia
                    	<?php echo $selectLicencias->traerResultados(); ?>
                    </td>
				</tr>
				<tr align="center">
					<td colspan="4">
                 		<div id="enfermedades">Enfermedad 
                 			<input class="id_busqueda guardar_datos" name="codigoEnf" id="id_enfermedad" type="text" autocomplete="off" style="width: 70%;" value="<?php echo $tratamiento->idEnfermedad . "-" . $tratamiento->enfermedad; ?>" <?php echo $habilitar_form; ?>/>
                 			<div id="busqueda_enfermedad" style= "width: 100%; height: 100%; " ></div>
                 		</div>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<strong>Evoluci&oacute;n de la licencia</strong>
						<div id="txtHint" style= "width:100%; height: 100%; " ></div>
						<p>&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<strong>Fecha inicio: </strong>
						<?php echo $tratamiento->fechaInicio; ?> 	
					</td>
     				<td colspan="2" align="center">D&iacute;as otorgados: <?php echo $tratamiento->diasAsignados; ?>
     				<input name="dias_actual" id="dias_actual" type="hidden" value="<?php echo $tratamiento->diasAsignados; ?>" />
     				</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<strong>Fecha de cambio: </strong>
						<label>
        				<input type="text" name="txt_inicio" id="txt_inicio" value="<?php echo date("Y-m-d"); ?>" <?php echo $habilitar_form; ?>/>
        				<input name="f_inicio" id="f_inicio" type="hidden" value="<?php echo $tratamiento->fechaInicio; ?>" />
      					</label>
      					<input type="button"  id="btn_inicio" value="..." <?php echo $habilitar_form; ?>/>
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
     				<td colspan="2" align="center">D&iacute;as transcurridos: <?php echo $dias_transcurridos->format('%a d&iacute;as'); ?></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<strong>Fecha alta: </strong>
						<label>
        				<input type="text" name="txt_alta" id="txt_alta" value="<?php echo $tratamiento->fechaAlta; ?>" <?php echo $habilitar_form; ?>/>
        				<input name="f_alta" id="f_alta" type="hidden" value="<?php echo $tratamiento->fechaAlta; ?>" />
      					</label>
      					<input type="button"  id="btn_alta" value="..." <?php echo $habilitar_form; ?>/>
      					<script type="text/javascript">
      						Calendar.setup({
       							button	   : "btn_alta",
								inputField : "txt_alta",
        						trigger    : "btn_alta",
        						onSelect   : function() { this.hide(); calculoDiasExtra(document.getElementById("txt_alta").value);},
        						showTime   : 24,
        						dateFormat : "%Y-%m-%d"
      						});
    					</script> 	
					</td>
     				<td colspan="2" align="center">
						D&iacute;as agregados
                    	<input type="text" name="txt_diasExtra" id="txt_diasExtra" autocomplete="off" <?php echo $habilitar_form; ?> onkeyup="calculoAlta(this.value)"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<strong>Estado de la licencia: </strong> <?php echo $tratamiento->estado; ?> 
					</td>
					<td colspan="2" align="center" valign="middle">Descripci&oacute;n - 
						<textarea name="descripcion_trat" id="descripcion_trat" <?php echo $habilitar_form; ?> ><?php echo $tratamiento->descripcion; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<p>&nbsp;</p>
						<button type="button" name="btn_guardar" id="btn_guardar" value="Guardar" <?php echo $habilitar_form; ?> onclick="validacionFormulario(this.value)" ><img src="./img/save.ico" /><br/>Guardar</button>
						<button type="button" name="btn_alta" id="btn_alta" value="Dar de alta" <?php echo $habilitar_form; ?> onclick="validacionFormulario(this.value)" ><img src="./img/add-favorite.ico" /><br/>Dar de alta</button>
					</td>
					<td colspan="2" align="center">
						<p>&nbsp;</p>
						<button type="button" name="btn_borrar" id="btn_alta" value="Eliminar tratamiento" <?php echo $eliminar; ?> onclick="confirmarEliminar()"><img src="./img/stop.ico" /><br/>Eliminar tratamiento</button>
					</td>
					<td>
						<input type="hidden" name="operacion" id="operacion" value="Guardar" />
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
</form>
</body>
</html>