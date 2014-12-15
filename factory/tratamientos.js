/**
 * Created by artiom on 12/11/14.
 */

myapp.factory('tratamientosFactory', function($http, dialogs){

	var factory = {};

	factory.nuevoTratamiento = function(tratamiento, callback){
		$http({
			method: 'POST',
			url: 'php/nuevoTratamiento.php',
			data: JSON.stringify(tratamiento)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.guardarTratamiento = function(cambios, callback){
		$http({
			method: 'POST',
			url: 'php/guardarTratamiento.php',
			data: JSON.stringify(cambios)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.altaTratamiento = function(tratamiento, callback){
		$http({
			method: 'POST',
			url: 'php/altaTratamiento.php',
			data: JSON.stringify(tratamiento)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.traerTratamientos = function(pagina, filtros, callback){
		var postData = {
			filtros: filtros,
			pagina: pagina
		};
		$http({
			method: 'POST',
			url: 'php/traerTratamientos.php',
			data: JSON.stringify(postData)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.generarListados = function(filtros, callback){
		$http({
			method: 'POST',
			url: 'php/generarListados.php',
			data: JSON.stringify(filtros)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.tratamientoPorId = function(idtrat, callback){
		$http({
			method: 'POST',
			url: 'php/tratamientoPorId.php',
			data: JSON.stringify(idtrat)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.traerTiposLicencias = function(callback){
		$http({
			method: 'GET',
			url: 'php/traerTiposLicencias.php'
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.detallesTipoLicencia = function(tipoLicencia, callback){
		$http({
			method: 'POST',
			url: 'php/detallesTipoLicencia.php',
			data: JSON.stringify(tipoLicencia)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.traerEvolucion = function(tratamiento, callback){
		$http({
			method: 'POST',
			url: 'php/traerEvolucion.php',
			data: JSON.stringify(tratamiento)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.puedoEliminarTratamiento = function(tratamiento, callback){
		$http({
			method: 'POST',
			url: 'php/puedoEliminarTratamiento.php',
			data: JSON.stringify(tratamiento)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.eliminarTratamiento = function(tratamiento, callback){
		$http({
			method: 'POST',
			url: 'php/eliminarTratamiento.php',
			data: JSON.stringify(tratamiento)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.proximasAltas = function(callback){
		$http({
			method: 'GET',
			url: 'php/proximasAltas.php'
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	return factory;

});
