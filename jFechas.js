function strAFecha(str){
	var cadena = new String(str);
	var arr_fecha = cadena.split("-");
	var jmes = arr_fecha[1] - 1;
	var fecha = new Date(arr_fecha[0], jmes, arr_fecha[2]);
	return fecha;
}

function calculoAlta(diasOtorgados){
	var f_inicio = strAFecha(document.getElementById('f_alta').value);
	var f_alta = new Date(f_inicio.valueOf() + (diasOtorgados * 24 * 60 * 60 * 1000));
	var fechaISO = f_alta.toISOString().substring(0, 10);
	document.getElementById("txt_alta").value = fechaISO;
}

function calculoAlta2(diasOtorgados){
	var f_inicio = strAFecha(document.getElementById('txt_inicio').value);
	var f_alta = new Date(f_inicio.valueOf() + ((diasOtorgados - 1) * 24 * 60 * 60 * 1000));
	var fechaISO = f_alta.toISOString().substring(0, 10);
	document.getElementById("txt_alta").value = fechaISO;
}

function calculoDiasExtra(fechaFinal){
	var f_inicio = strAFecha(document.getElementById('f_alta').value);
	var f_alta = strAFecha(fechaFinal);
	var diffEnDias = (f_alta.valueOf() - f_inicio.valueOf()) / (24 * 60 * 60 * 1000);
	document.getElementById("txt_diasExtra").value = diffEnDias;
}

function calculoDiasOtorgados(fechaFinal){
	var f_inicio = strAFecha(document.getElementById('txt_inicio').value);
	var f_alta = strAFecha(fechaFinal);
	var diffEnDias = (f_alta.valueOf() - f_inicio.valueOf()) / (24 * 60 * 60 * 1000);
	document.getElementById("txt_diasExtra").value = diffEnDias + 1;
}

function fechaDeCambio(){
	var ultimaAlta = strAFecha(document.getElementById('f_alta').value);
	var cambio = new Date(ultimaAlta.valueOf());
	var fechaCambioISO = cambio.toISOString().substring(0, 10);
	return fechaCambioISO;
}

function validoFechaAlta(){
	var nueva_alta = strAFecha(document.getElementById("txt_alta").value);
	var fecha_inicio = strAFecha(fechaDeCambio());
	if (nueva_alta.valueOf() >= fecha_inicio.valueOf()){
		return true;
	}
	else {
		alert("La fecha de alta no puede ser menor al: " + fechaDeCambio());
		return false;
	}
}

function validoTipoLicencia(){
	var tipo_licencia = document.getElementById("tipo_licencia").value;
	var dias_actual = parseInt(document.getElementById("dias_actual").value, 10);
	var dias_extra = parseInt(document.getElementById("txt_diasExtra").value, 10);
	
	if (dias_extra < 0){
		alert("Los d\u00EDas agregados deben ser un n\u00FAmero mayor o igual a 0");
		return false;
	}
	
	var dias_total = dias_actual + dias_extra;
	
	switch (tipo_licencia){
	case "CT":
		if (dias_total <= 14){
			return true;
		}
		break;
	case "LT":
		if (dias_total > 14){
			return true;
		}
		break;
	case "MA":
		if (dias_total <= 100){
			return true;
		}
		break;
	case "A17G":
		if (dias_total <= 20){
			return true;
		}
		break;
	case "A17S":
		if (dias_total <= 10){
			return true;
		}
		break;
	case "ART9":
		if (dias_total <= 5){
			return true;
		}
		break;
	case "ACC":
	case "SL":
		return true;
		break;
	}
	
	alert("Los d\u00EDas totales asignados superan el m\u00E1ximo de la licencia seleccionada");
	return false;
}

function validacionFormulario(btnPresionado){
	document.getElementById("operacion").value = btnPresionado;
	if (btnPresionado == "Guardar"){
		if (validoFechaAlta() && validoTipoLicencia()){
			document.getElementById("frmPrincipal").submit();
		}
	}
	else {
		if (confirm("Se dar\u00E1 de alta el tratamiento, \u00BFconfirma la operaci\u00F3n?")){
			document.getElementById("frmPrincipal").submit();
		}
	}
}

function confirmarEliminar(){
	if (confirm("Est\u00E1 a punto de eliminar el tratamiento, \u00BFconfirma la operaci\u00F3n?")){
		document.forms.frmPrincipal.action = "borrarTratamiento.php";
		document.forms.frmPrincipal.submit();
	}
}

function validarNuevoTratamiento(){
	if (validoCampos() && validoNuevaLicencia() && validoFechas()){
		document.getElementById("frmPrincipal").submit();
	}
}

function validoNuevaLicencia(){
	var tipo_licencia = document.getElementById("tipo_licencia").value;
	var dias_asignados = parseInt(document.getElementById("txt_diasExtra").value);
	var enfermedad = document.getElementById("id_enfermedad").value;
	
	if (dias_asignados <= 0){
		alert("Los d\u00EDas agregados deben ser un n\u00FAmero mayor a 0");
		return false;
	}
	
	switch (tipo_licencia){
	case "CT":
		if (dias_asignados <= 14 && enfermedad != "Ingrese Codigo de Enfermedad o Enfermedad" && enfermedad != ""){
			return true;
		}
		break;
	case "LT":
		if (dias_asignados > 14 && enfermedad != "Ingrese Codigo de Enfermedad o Enfermedad" && enfermedad != ""){
			return true;
		}
		break;
	case "MA":
		if (dias_asignados <= 100){
			return true;
		}
		break;
	case "A17G":
		if (dias_asignados <= 20){
			return true;
		}
		break;
	case "A17S":
		if (dias_asignados <= 10){
			return true;
		}
		break;
	case "ART9":
		if (dias_asignados <= 5){
			return true;
		}
		break;
	case "ACC":
	case "SL":
		return true;
		break;
	}
	
	alert("Los d\u00EDas totales asignados superan el m\u00E1ximo de la licencia seleccionada o la enfermedad seleccionada es incorrecta");
	return false;
}

function validoFechas(){
	var alta = strAFecha(document.getElementById("txt_alta").value);
	var inicio = strAFecha(document.getElementById("txt_inicio").value);
	var fecha_actual = new Date();
	if (inicio.valueOf() > fecha_actual.valueOf()){
		alert("La fecha de inicio no puede ser en el futuro");
		return false;
	}
	else {
		if (alta.valueOf() >= inicio.valueOf()){
			return true;
		}
		else {
			alert("La fecha de alta no puede ser menor al: " + fechaDeCambio());
			return false;
		}
	}
}

function validoCampos(){
	var inicio = document.getElementById("txt_inicio").value;
	var alta = document.getElementById("txt_alta").value;
	var dias = document.getElementById("txt_diasExtra").value;
	var usuario = document.getElementById("id_busqueda_persona").value;
	
	if (inicio != "" && alta != "" && dias != "" && (usuario != "" && usuario != "Ingrese Legajo o Apellido y Nombre")){
		return true;
	}
	else {
		alert("Debe indicar fecha de inicio, de alta, dias otorgados y empleado");
		return false;
	}
		
}

function opcionListado(btnPresionado){
	if (btnPresionado == "listado"){
		document.getElementById("frmListado").action = "mostrarListado.php";
	}
	else {
		document.getElementById("frmListado").action = "generoExcel.php";
	}
	
	document.getElementById("frmListado").submit();	
}