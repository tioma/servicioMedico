/**
 * Created by artiom on 02/12/14.
 */
function seguridadCtrl($scope, authFactory, loginService, $state, authFactory, $timeout){

	$scope.nuevoUsuario = false;

	$scope.panelUsuario = {
		tipo: '',
		titulo: '',
		mensaje: ''
	};
	$scope.mostrarPanelUsuario = false;

	$scope.$on('error', function(event, data){
		$scope.dataHandler(data, function(datos){})
	});

	$scope.crearUsuario = function(){
		$scope.usuario = {
			usuario: '',
			tratamientos: '',
			listados: '',
			parametros: ''
		};
		$scope.nuevoUsuario = true;
	};

	$scope.cancelar = function(){
		$scope.nuevoUsuario = false;
	};

	$scope.guardarNuevoUsuario = function(){
		authFactory.nuevoUsuario($scope.usuario, function(data){
			$scope.dataHandler(data, function(datos){
				$scope.panelUsuario = {
					tipo: 'alert-success',
					titulo: 'Éxito',
					mensaje: 'El nuevo usuario ha sido agregado con éxito.'
				};
			});
			$scope.mostrarPanelUsuario = true;
			$timeout(function(){
				$scope.mostrarPanelUsuario = false;
			}, 4000);
		})
	};

	$scope.dataHandler = function(data, callback){
		switch (data.status) {
			case 'OK':
				callback(data);
				break;
			case 'ERROR':
				$scope.panelUsuario = {
					tipo: 'alert-danger',
					titulo: 'Error',
					mensaje: data.data.mensajeError
				};
				break;
			case 'FORBIDDEN':
				$state.transitionTo('forbidden');
				break;
			case 'NOTLOGGED':
				authFactory.logout();
				$state.transitionTo('login');
				loginService.unsetLogin();
				break;
		}
	};

}
