/**
 * Created by artiom on 13/11/14.
 */
myapp.factory('enfermedadesFactory', function($http, dialogs){
	var factory = {};

	factory.traerEnfermedades = function(callback){
		$http({
			method: 'GET',
			url: 'php/traerEnfermedades.php'
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.guardarEnfermedad = function(enfermedad, callback){
		$http({
			method: 'POST',
			url: 'php/guardarEnfermedad.php',
			data: JSON.stringify(enfermedad)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.altaEnfermedad = function(enfermedad, callback){
		$http({
			method: 'POST',
			url: 'php/altaEnfermedad.php',
			data: JSON.stringify(enfermedad)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.eliminarEnfermedad = function(enfermedad, callback){
		$http({
			method: 'POST',
			url: 'php/eliminarEnfermedad.php',
			data: JSON.stringify(enfermedad)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	return factory;
});