/**
 * Created by leo on 18/07/14.
 */
(function(){

myapp.factory('authFactory', function($http, $cookies, $cookieStore, loginService, dialogs, $state){
	var factory = {};

	factory.setCookies = function(user, pass){
		$cookies.username = user;
		$cookies.password = pass;
	};

	factory.login = function(user, pass, callback){
		user = user || $cookies.username;
		pass = pass || $cookies.password;

		var formData = {
			"email": user,
			"password": pass
		};
		$http({
			method: 'POST',
			url: 'php/login.php',
			data: JSON.stringify(formData)
		}).success(function(data) {
			if (data.status != 'ERROR') {
				loginService.setInfo(data.data);
				loginService.setStatus(true);
				loginService.setAcceso(data.data.permisos);

				callback(data.data);
			} else {
				dialogs.error('Error al iniciar sesión', 'Usuario o clave incorrectos.');
			}
		}).error(function(errorNumber) {
			if (errorNumber === 403){
				dialogs.error('Error al iniciar sesión', 'Usuario o clave incorrectos.');
			} else {
				dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
			}
		});

	};

	factory.logout = function(){
		$cookieStore.remove('username');
		$cookieStore.remove('password');
		$cookieStore.remove('themeTerminal');
	};

	factory.userEstaLogeado = function(){
		return (angular.isDefined($cookies.username) && angular.isDefined($cookies.password) && $cookies.username != '' && $cookies.password != '');
	};

	factory.traerUsuarios = function(callback){
		$http({
			method: 'GET',
			url: 'php/traerUsuarios.php'
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.guardarCambios = function(usuario, callback){
		$http({
			method: 'POST',
			url: 'php/guardarUsuario.php',
			data: JSON.stringify(usuario)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.nuevoUsuario = function(usuario, callback){
		$http({
			method: 'POST',
			url: 'php/nuevoUsuario.php',
			data: JSON.stringify(usuario)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	factory.eliminarUsuario = function(usuario, callback){
		$http({
			method: 'POST',
			url: 'php/eliminarUsuario.php',
			data: JSON.stringify(usuario)
		}).success(function(data) {
			callback(data);
		}).error(function() {
			dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
		});
	};

	return factory;
});

})();