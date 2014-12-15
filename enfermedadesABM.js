jQuery(document).ready(function($)
{

//-----------------------------------------------
//ABM Enfermedades
$('.ocultaEnfermedad').click(function(){
	$('.camposCodigoEnfermedad').slideUp('fast');
	$('.camposDeBusqueda').slideDown('fast');
	$('#campo_codigo').prop('disabled',true);
	$('#confirmar').css('display','none');
	$('#TipoCambio').val($(this).val());
});
$('.ocultaBusqueda').click(function(){
	$('.camposCodigoEnfermedad').slideDown('fast');
	$('.camposDeBusqueda').slideUp('fast');
	$('#campo_codigo').prop('disabled',false);
	$('#campo_enfermedad').prop('disabled',false);
	$('#confirmar').css('display','');
	$('#TipoCambio').val($(this).val());
});
$('.limpiaCamposBusqueda').click(function(){
	$('#id_enfermedad').val($('#id_enfermedad').data('valor'));
	$('#campo_codigo').val($('#campo_codigo').data('valor'));
	$('#campo_enfermedad').val($('#campo_enfermedad').data('valor'));
});
$('.ocultaModificar').click(function(){
	$('#campo_enfermedad').prop('disabled',false);
});
$('.ocultaEliminar').click(function(){
	$('#campo_codigo').prop('disabled',true);
	$('#campo_enfermedad').prop('disabled',true);
});
$('#botonConfirmar').click(function(event){
	if ($('#campo_codigo').val() == $('#campo_codigo').data('valor') || $('#campo_enfermedad').val() == $('#campo_enfermedad').data('valor'))
		event.preventDefault();
	else {
		$('#campo_codigo').prop('disabled',false);
		$('#campo_enfermedad').prop('disabled',false);
	}
});

//-----------------------------------------------
//Busqueda General PRUEBA
$('.id_busqueda_prueba').keyup(function(){
	$(this).next('div').slideDown('slow');
	$(this).next('div').load('resultados.php',{par: $(this).attr('name'), valor: $(this).val()},function(){
		$('.seleccionEnfermedad').click(function(){
			$('.id_busqueda_prueba').val($(this).attr('id').split('---')[1]);
			$('#campo_codigo').val($('.id_busqueda_prueba').val().split(' - ')[0]);
			$('#campo_enfermedad').val($('.id_busqueda_prueba').val().split(' - ')[1]);
			$('.camposCodigoEnfermedad').css('display','');
			$('#confirmar').css('display','');
			$('.div_busqueda').slideUp('slow');
		});
	});
	$(this).next('.txtHint').empty();
});

//-----------------------------------------------
//Validacion
/*$('#formEnfermedadesABM').validate({
	rules: {
		campo_codigo: 'maxlength: 4',
		campo_enfermedad: 'maxlength: 60'
	},
	messages: {
		campo_codigo: 'maxlength: "Introduzca un codigo de 4 caracteres maximo"',
		campo_enfermedad: 'maxlength: "Introduzca una enfermedad de 60 caracteres maximo"'
	},
	debug: true,
	submitHandler: function(form){
	alert('El formulario ha sido validado correctamente!');
	}
});*/

});