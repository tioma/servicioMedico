<?php

include_once 'loginseg.php';
include_once 'Estadistica.php';

$grafico = new promedioDiasLicencia();
$periodo = "";

if ($_POST['txt_inicio'] != ""){
	$inicio = $_POST['txt_inicio'];
	$grafico->setInicio($inicio);
	$mes = traducirMes(date('M', strtotime($inicio)));
	
	$periodo = "Correspondiente al per&iacute;odo desde el " . date('d', strtotime($inicio)) . " de " . $mes . " del " . date('Y', strtotime($inicio));	
}

if ($_POST['txt_hasta'] != ""){
	$final = $_POST['txt_hasta'];
	$grafico->setFinal($final);
	$mes = traducirMes(date('M', strtotime($final)));
	
	$periodo .= " hasta el " . date('d', strtotime($final)) . " de " . $mes . " del " . date('Y', strtotime($final));	
}

function traducirMes ($unMes){
	switch ($unMes){
		case "Jan":
			return "Enero";
			break;
		case "Feb":
			return "Febrero";
			break;
		case "Mar":
			return "Marzo";
			break;
		case "Apr":
			return "Abril";
			break;
		case "May":
			return "Mayo";
			break;
		case "Jun":
			return "Junio";
			break;
		case "Jul":
			return "Julio";
			break;
		case "Aug":
			return "Agosto";
			break;
		case "Sep":
			return "Septiembre";
			break;
		case "Oct";
			return "Octubre";
			break;
		case "Nov":
			return "Noviembre";
			break;
		case "Dec":
			return "Diciembre";
			break;
	}
}

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
    	<td align="center" colspan="2">
    		<form action="mostrarListado.php"></form>
			<table>
				<tr align="center">
                	<td colspan="3">
                		<div class="tituloPag">Estad&iacute;stica<br/>
                		<?php echo $periodo; ?></div><br/>
                	</td>
                </tr>
				<tr align="center">
					<td>
						<?php
							echo $grafico->generar();
						?>
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