var seleccion = false;

jQuery(document).ready(function($)
{
	//------------------------------------------------------------------------------
	//Para actualización de licencias
	$('#btn_mostrar').click(function(){
		$('#datos_licencia').empty();
		if (!seleccion){ $('#datos_licencia').slideUp('slow'); }
			else { $('#datos_licencia').slideDown('slow'); }
		xval = $('#id_busqueda_persona').val();
		$('#datos_licencia').load('licenciasPersona.php',{persona: xval});
	});
	$("#id_busqueda_persona").keypress(function(event) {
		if ( event.which == 13 ){
			event.preventDefault();
		    $('#btn_mostrar').click();
		} else {
			$('#datos_licencia').empty();
			seleccion = false;
		}
	});
	//-----------------------------------------------------------------------------------
	//Para licencias cercanas a vencimiento - Listado
	$('#vencimiento').click(function(){
		$('#divLicencias').empty();
		param = "diasRestantes";
		xval = $('#dias_vencimiento').val();
		
		if (xval == '' || xval.length > 10){ 
			$('#divLicencias').slideUp('slow');
		}else {
			$('#divLicencias').slideDown('slow');
			$('#divLicencias').load('resultados.php',{par: param, valor: xval});
		}
		if (xval >= 1000){
			$('#divLicencias').height(500);
		}
		else {
			$('#divLicencias').height("100%");
		}
		
	});
	
	$('#aExcel').click(function(){
		$('#frm_principal').submit();
	});
	
	$("#cargando").on("ajaxStart", function(){
	    $(this).show(); // this hace referencia a la div con la imagen.
	}).on("ajaxStop", function(){
	    $(this).hide();
	});
	$("#dias_vencimiento").keypress(function(event) {
		if ( event.which == 13 ){
			event.preventDefault();
		    $('#vencimiento').click();
		}
	});
	//-----------------------------------------------
	//Cambio entre Licencias Acumuladas - Otras Licencias
	$('.licenciasA').click(function(){
		if ($(this).val() == 'licenciasAcumuladas') {$('#licenciasAcumuladas').attr('name','licenciasAcumuladas');} else {$('#licenciasAcumuladas').attr('name','otrasLicencias');}
		if ($('.id_busqueda_sin_ocultar').val() == $('.guardar_datos').data('valor')) { xval = ''; } else {xval = $('.id_busqueda_sin_ocultar').val();}
		$('.id_busqueda_sin_ocultar').next('div').load('resultados.php',{par: $('.id_busqueda_sin_ocultar').attr('name'), valor: xval});
	});
	//-----------------------------------------------
	//Busqueda General
	$('.id_busqueda').keyup(function(event){
		if ( event.which == 13 || event.which == 8){
			event.preventDefault();
		}
		
		if ($(this).val() == ''){
			$(this).next('div').slideUp('slow');
		} else {
			$(this).next('div').slideDown('slow');
		}
		$(this).next('div').load('resultados.php',{par: $(this).attr('name'), valor: $(this).val()});
		$(this).next('.txtHint').empty();
		
	});
	//-----------------------------------------------
	//Busqueda General sin ocultar
	$('.id_busqueda_sin_ocultar').keyup(function(event){
		if ( event.which == 13 || event.which == 8){
			event.preventDefault();
		}
		if ($('.id_busqueda_sin_ocultar').val() == $('.guardar_datos').data('valor')) {
			xval = '';
		} else {
			xval = $('.id_busqueda_sin_ocultar').val();
		}
		$(this).next('div').load('resultados.php',{par: $(this).attr('name'), valor: $(this).val()});
		$(this).next('.txtHint').empty();
		
	});
	//-----------------------------------------------
	//Guardar datos y mostrarlo - Focus in Focus out
	$('.guardar_datos').each(function(){  $(this).data('valor', $(this).val()); });
	$('.guardar_datos').focusout(function(){ if ($(this).val() == '') { $(this).val($(this).data('valor')); } });
	$('.guardar_datos').focusin(function(){ if ($(this).val() == $(this).data('valor')) { $(this).val(''); } });
	//-----------------------------------------------
	//Carga Inicial - Trae tabla sin filtros
	$('.cargar_tabla_sin_filtro').next('div').load('resultados.php',{par: $('.cargar_tabla_sin_filtro').attr('name')},function(){
		$('.seleccionEnfermedad').click(function(){
			$('.id_busqueda_prueba').val($(this).attr('id').split('---')[1]);
			$('#campo_codigo').val($('.id_busqueda_prueba').val().split(' - ')[0]);
			$('#campo_enfermedad').val($('.id_busqueda_prueba').val().split(' - ')[1]);
			$('.camposCodigoEnfermedad').css('display','');
			$('#confirmar').css('display','');
			$('.div_busqueda').slideUp('slow');
		});
	});
	//-----------------------------------------------
	//Otros visual
	$('.oculto').slideUp('fast');
	$('.noOculto').slideDown('fast');
});

function seleccionarEnfermedad(codigo, enfermedad){
	document.getElementById("id_enfermedad").value = codigo + "-" + enfermedad;
	document.getElementById("busqueda_enfermedad").style.display = 'none';
}

function seleccionarEnfermedad2(codigo, enfermedad){
	document.getElementById("id_enfermedad").value = codigo + "-" + enfermedad;
	document.getElementById("campo_codigo").value = codigo;
	document.getElementById("campo_enfermedad").value = enfermedad;
	document.getElementById("campoEnfermedad").style.display = '';
	document.getElementById("confirmar").style.display = '';
	document.getElementById("busqueda_enfermedad").style.display = 'none';
}

function seleccionarPersona(unaPersona){
	seleccion = true;
	document.getElementById("id_busqueda_persona").value = unaPersona;
	document.getElementById("div_busqueda_persona").style.display = 'none';
	
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    },

    xmlhttp.open("GET","tratamientoEnCurso.php?empleado="+unaPersona,true);
    xmlhttp.send();
}

function escondoEnfermedad(){
	var tipo_licencia = document.getElementById("tipo_licencia").value;
	
	switch (tipo_licencia){
	case "CT":
	case "LT":
		document.getElementById("enfermedad").style.display = 'block';
		document.getElementById("fecha_alta").style.display = 'block';
		document.getElementById("estado_lic").style.display = 'block';
		document.getElementById("dias_otorgados").style.display = 'block';
		break;
	case "MA":
	case "A17G":
	case "A17S":
	case "ACC":
	case "ART9":
		document.getElementById("enfermedad").style.display = 'none';
		document.getElementById("fecha_alta").style.display = 'block';
		document.getElementById("estado_lic").style.display = 'block';
		document.getElementById("dias_otorgados").style.display = 'block';
		break;
	case "SL":
		document.getElementById("enfermedad").style.display = 'none';
		document.getElementById("fecha_alta").style.display = 'none';
		document.getElementById("estado_lic").style.display = 'none';
		document.getElementById("dias_otorgados").style.display = 'none';
		
		var dias_otorgados = '1';
		document.getElementById("txt_diasExtra").value = dias_otorgados;
		document.getElementById("estado_licencia").value = 'A';
		calculoAlta2(dias_otorgados);
		break;
	}

}

function calculoRestantes(diasAcum){
	if (diasAcum == ""){
		document.getElementById("restantes").value = "1095";
	} else {
		var dias_acum = parseInt(diasAcum, 10);
		var dias_rest = 1095 - dias_acum;
		document.getElementById("restantes").value = dias_rest;
	}
}

function calculoAcum(diasRestantes){
	if (diasRestantes == ""){
		document.getElementById("acumulados").value = "1095";
	} else {
		var dias_rest = parseInt(diasRestantes, 10);
		var dias_acum = 1095 - dias_rest;
		document.getElementById("acumulados").value = dias_acum;
	}
}

function confirmoListado(desde, hasta){
	var dif_anos = parseInt(hasta) - parseInt(desde);
	if (dif_anos >= 10){
		alert("El per\u00EDodo seleccionado no puede superar los 10 a\u00F1os");
	} else {
		document.forms.frmListado.submit();
	}
}