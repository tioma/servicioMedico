/**
 * Created by Artiom on 14/03/14.
 */

function navigationCtrl($scope, $state, loginService, authFactory){
	"use strict";

	$scope.salir = function(){
		authFactory.logout();
		$state.transitionTo('login');
		loginService.unsetLogin();
	};

	$scope.irA = function(){
		if (loginService.getStatus()){
			$state.transitionTo($state.current.name);
			window.location.reload();
		} else{
			$state.transitionTo('login');
		}
	};

	$scope.$watch(function(){
		if (loginService.getStatus()){
			$scope.tratamientos = loginService.getAcceso().tratamientos;
			$scope.listados = loginService.getAcceso().listados;
			$scope.parametros = loginService.getAcceso().parametros;
			$scope.usuario = loginService.getAcceso().usuario;
		} else {
			$scope.tratamientos = 0;
			$scope.listados = 0;
			$scope.parametros = 0;
			$scope.usuario = '';
		}
	})

}
