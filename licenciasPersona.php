<?php 
	include_once 'Empleado.php';

	$datos_empleado = split("-", $_REQUEST['persona']);
	$empleado = new Empleado(trim($datos_empleado[0]), $datos_empleado[1]);
	
	echo '<script type="text/javascript" src="./jquery.js"></script>';
	echo '<table>';
	echo '<tr align="center">';
	echo '<td colspan="2">D&iacute;as acumulados: ';
	echo '<input type="text" size="50" name="acumulados" id="acumulados" autocomplete="off" value="' . $empleado->diasAcumulados . '" onkeyup="calculoRestantes(this.value)"/>';
	echo '</td>';
	echo '</tr>';
	echo '<tr align="center">';
	echo '<td colspan="2">D&iacute;as restantes: ';
	echo '<input type="text" size="50" name="restantes" id="restantes" autocomplete="off" value="' . $empleado->diasRestantes . '" onkeyup="calculoAcum(this.value)"/>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="2" align="center">';
	echo '<div id="div_fecha" >&Uacute;ltima ausencia: ';
	echo '<label>';
	echo '<input type="text" name="ultimaAus" id="ultimaAus" value="' . $empleado->ultimaAusencia . '"/>';
	echo '</label>';
	echo '<input type="button" id="btn_aus" value="..." />';
	echo '<script type="text/javascript">
			Calendar.setup({
    			button: "btn_aus",
				inputField: "ultimaAus",
        		trigger: "btn_aus",
        		onSelect: function() { this.hide(); },
        		showTime: 24,
        		dateFormat : "%Y-%m-%d"
			});
		 </script>';
	echo '</div>';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="2" align="center">Ausencia nula: ';
	echo '<input type="checkbox" name="sin_aus" id="sin_aus" />';
	echo '</td>';
	echo '</tr>'; 
	echo '<tr>';
	echo '<td align="center" colspan="2">';
	echo '<button type="button" id="btn_guardar" value="Guardar" >Guardar</button>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<script type="text/javascript">';
	echo '$("#sin_aus").click(function(){
			$("#ultimaAus").val("");
			$("#div_fecha").toggle();
		});
		$("#btn_guardar").click(function(){
			persona = $("#id_busqueda_persona").val();
			acumulados = $("#acumulados").val();
			restantes = $("#restantes").val();
			ultAus = $("#ultimaAus").val();
			$("#datos_licencia").load("actualizarLicencia.php",{empleado: persona, acum: acumulados, rest: restantes, ultimaAus: ultAus});
		});
		</script>';
	
?>

