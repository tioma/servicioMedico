/**
 * Created by Diego Reyes on 3/19/14.
 */
myapp.factory('userFactory', function($http, dialogs){
	var factory = {};

	factory.login = function(user, pass, callback){
		"use strict";
		var formData = {
			"email": user,
			"password": pass
		};
		$http({
			method: 'POST',
			url: 'php/login.php',
			data: JSON.stringify(formData)
		}).success(function(data) {
			callback(data);
		}).error(function(errorNumber) {
			if (errorNumber === 403){
				dialogs.error('Error al iniciar sesión', 'Usuario o clave incorrectos.');
			} else {
				dialogs.error('Error de servidor', 'Ha ocurrido un error al conectarse, inténtelo nuevamente más tarde');
			}
		});
	};

	return factory;
});