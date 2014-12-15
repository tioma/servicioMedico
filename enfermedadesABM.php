<?php

include_once 'loginseg.php';

$validacion = new validoUsuario("parametros");
$validacion->validar($_SESSION['permisos']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="EstilosIntegrador.css" rel="stylesheet" type="text/css"/>
<title>Sistema de Servicio M&eacute;dico</title>
<script type="text/javascript" src="blue-menu.files/dmenu.js"></script>
<script type="text/javascript" src="./jquery.js"></script>
<script type="text/javascript" src="./jQueryEnfermedad.js"></script>
<script type="text/javascript" src="./enfermedadesABM.js"></script>
<script type="text/javascript" src="./jquery-validation/dist/jquery.validate.js"></script>

</head>
<body>
<br /> <br />
<div class="TablaPrincipal">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<form id="formEnfermedadesABM" method="post" action="enfermedadesActualizacion.php">
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
					<td align="center" colspan="2"><strong>Men&uacute; ABM de Enfermedades</strong></td>
				</tr>
				<tr>
                	<td align="center">
						<table>
							<tr class="limpiaCamposBusqueda">
								<td><input type="button" value="Nuevo" class="BotonCeleste ocultaBusqueda" /></td>
								<td><input type="button" value="Modificar" class="BotonCeleste ocultaEnfermedad ocultaModificar"/></td>
								<td><input type="button" value="Eliminar" class="BotonCeleste ocultaEnfermedad ocultaEliminar"/></td>
								<input id="TipoCambio" name="TipoCambio" type="hidden" value=""/>
							</tr>
						</table>
					</td>
				</tr>
                <tr class="camposDeBusqueda oculto">
                	<td align="center">
                		<input type="text" size="50" name="codigoEnf3" class="id_busqueda_prueba guardar_datos cargar_tabla_sin_filtro" id="id_enfermedad" autocomplete="off" value="Ingrese Codigo de Enfermedad o Enfermedad"/>
						<div class="div_busqueda" id="busqueda_enfermedad" style= "width: 100%; height: 200px; overflow: auto;"></div>
                	</td>
                </tr>
				<tr class="camposCodigoEnfermedad oculto" id="campoEnfermedad">
					<td align="center">
						<table>
							<tr>
								<td><input type="text" size="5" id="campo_codigo" name="campo_codigo" value="C&oacute;digo" class="guardar_datos" maxlength="4"/></td>
								<td><input type="text" size="40" id="campo_enfermedad" name="campo_enfermedad" value="Enfermedad" class="guardar_datos" maxlength="60"/></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="oculto" id="confirmar">
					<td align="center">
						<input type="submit" id="botonConfirmar" value="Confirmar" class="BotonCeleste" />
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
</form>
</table>
</div>
</body>
</html>