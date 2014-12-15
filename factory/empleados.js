/**
 * Created by artiom on 21/11/14.
 */
myapp.factory('empleadosFactory', function($http, dialogs){
	var factory = {};

	factory.traerEmpleados = function(callback){
		$http({
			method: 'GET',
			url: 'php/traerEmpleados.php'
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.actualizarLicencia = function(datosEmpleado, callback){
		$http({
			method: 'POST',
			url: 'php/actualizarLicencia.php',
			data: JSON.stringify(datosEmpleado)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	return factory;
});
