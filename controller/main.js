/**
 * Created by kolesnikov-a on 21/02/14.
 */

google.load("visualization", "1", {packages:["corechart"]});

Array.prototype.contains = function (item) {
	var result = false;
	this.forEach(function (data) {
		if (data === item)
			result = true;
		return result;
	});
	return result;
};

function in_array(needle, haystack, argStrict){
	var key = '',
		strict = !! argStrict;

	if(strict){
		for(key in haystack){
			if(haystack[key] === needle){
				return true;
			}
		}
	}else{
		for(key in haystack){
			if(haystack[key] == needle){
				return true;
			}
		}
	}
	return false;
}

var myapp = angular.module('myapp', ['ui.router','ui.bootstrap', 'ngSanitize', 'ngCookies', 'angucomplete-alt']);

myapp.config(['$httpProvider', function ($httpProvider) {

	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	$httpProvider.defaults.transformRequest = [function (data) {
		/**
		 * The workhorse; converts an object to x-www-form-urlencoded serialization.
		 * @param {Object} obj
		 * @return {String}
		 */
		var param = function (obj) {
			var query = '';
			var name, value, fullSubName, subName, subValue, innerObj, i;

			for (name in obj) {
				value = obj[name];

				if (value instanceof Array) {
					for (i = 0; i < value.length; ++i) {
						subValue = value[i];
						fullSubName = name + '[' + i + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}
				else if (value instanceof Object) {
					for (subName in value) {
						subValue = value[subName];
						fullSubName = name + '[' + subName + ']';
						innerObj = {};
						innerObj[fullSubName] = subValue;
						query += param(innerObj) + '&';
					}
				}
				else if (value !== undefined && value !== null) {
					query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
				}
			}

			return query.length ? query.substr(0, query.length - 1) : query;
		};

		return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];
}]);

myapp.config(function ($stateProvider, $urlRouterProvider, $provide) {

	/*$provide.decorator("$exceptionHandler", function($delegate, $injector){
		return function(exception, cause){
			var $rootScope = $injector.get("$rootScope");
			$rootScope.addError({message:"Exception", reason:exception});
			$delegate(exception, cause);
		};
	});*/

	// For any unmatched url, send to /login
	$urlRouterProvider.otherwise("/login");

	//noinspection JSValidateTypes
	$stateProvider
		.state('login', {
			url: "/login",
			templateUrl: "view/login.html"
		})
		.state('loged', {
			url: "/loged",
			templateUrl: "view/loged.html"
		})
		.state('tratamientos', {
			url: "/tratamientos",
			templateUrl: "view/tratamientos.html"
		})
		.state('proximasAltas', {
			url: "/proximasAltas",
			templateUrl: "view/proximas.altas.html"
		})
		.state('seguridad', {
			url: "/seguridad",
			templateUrl: "view/seguridad.html"
		})
		.state('actualizarLicencias', {
			url: "/acumulados",
			templateUrl: "view/actualizador.licencias.html"
		})
		.state('enfermedades', {
			url: "/enfermedades",
			templateUrl: "view/enfermedadesABM.html"
		})
		.state('listados', {
			url: "/listados",
			templateUrl: "view/listados.html"
		})
		.state('forbidden', {
			url: "/forbidden",
			templateUrl: "view/forbidden.html"
		});

		/*
		.state('control', {
			url: "/control",
			templateUrl: "view/control.html",
			controller: "controlCtrl",
			resolve: { //Los datos de los gráficos deben venir cargados antes de llamar a la vista, por eso se utiliza el resolve
				datosGrafico: controlCtrl.primerCargaComprobantes,
				datosGraficoPorMes: controlCtrl.prepararMatrizVacía,
				datosFacturadoPorDiaTasas: controlCtrl.prepararMatrizTasas,
				datosGraficoGatesTurnosDias: controlCtrl.prepararMatrizVaciaGatesTurnos
			}
		})
		.state('cfacturas', {
			url: "/cfacturas",
			templateUrl: "view/controlComprobantes.html"
		})
		.state('gates', {
			url: "/gates",
			templateUrl: "view/gates.html"
		})
		.state('gates.invoices', {
			url: "/contenedor=:contenedor",
			templateUrl: "view/gates.invoices.html"
		})
		.state('turnos', {
			url: "/turnos",
			templateUrl: "view/turnos.html"
		})
		.state('changepass', {
			url: "/cambiarpass",
			templateUrl: "view/newpass.html"
		})
		.state('container',{
			url: "/contenedor",
			templateUrl: "view/container.html"
		})
		.state('buque',{
			url: "/buqueViaje",
			templateUrl: "view/buque.viaje.html"
		})
		.state('reports', {
			url: "/reportes",
			templateUrl:"view/reportes.html"
		})*/
});

myapp.run(function($rootScope, $state, loginService, $http, authFactory, dialogs){
	"use strict";

	// Variables Globales de Fecha
	$rootScope.dateOptions = { 'showWeeks': false };
	$rootScope.formatDate = 'yyyy-MM-dd';
	$rootScope.openDate = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
	};

	var rutasComunes = ['login', 'loged', 'forbidden', 'changepass', 'tratamientos', 'proximasAltas', 'seguridad', 'actualizarLicencias', 'enfermedades', 'listados'];

	$rootScope.$on('$stateChangeStart', function(event, toState){
		if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion < 10){
			dialogs.error('Error de navegador', 'La aplicación no es compatible con su versión de navegador. Los navegadores compatibles son Mozilla Firefox, Google Chrome y las versiones de IE mayores a 8.');
		}
		if (!loginService.getStatus() && authFactory.userEstaLogeado()){
			authFactory.login().then(function(){
				$rootScope.verificaRutas(event, toState);
			});
		} else {
			$rootScope.verificaRutas(event, toState);
		}
	});

	$rootScope.verificaRutas = function(event, toState){
		if (!in_array(toState.name, rutasComunes)){
			if (loginService.getStatus()){
				if(!in_array(toState.name, loginService.getAcceso())){
					$rootScope.usuarioNoAutorizado(event);
				}
			} else {
				$rootScope.usuarioNoAutorizado(event);
			}
		}
	};

	$rootScope.usuarioNoAutorizado = function(event){
		event.preventDefault();
		$state.transitionTo('forbidden');
	};
});
