/**
 * Created by artiom on 03/12/14.
 */
function licenciasAcumuladasCtrl($rootScope, $scope, empleadosFactory, authFactory, $state, loginService, $timeout){

	$scope.totalItems = 0;
	$scope.currentPage = 1;
	$scope.itemsPerPage = 10;
	$scope.search = '';
	$scope.mostrarPaginacion = true;
	$scope.mostrarPanelResultado = false;

	$scope.listaEmpleados = [];
	$scope.empleadosFiltrado = [];

	$scope.cargaDatos = function(){
		$scope.search = '';
		$scope.currentPage = 1;
		empleadosFactory.traerEmpleados(function(data){
			$scope.listaEmpleados = data;
			$scope.totalItems = $scope.listaEmpleados.length;
			$scope.empleado = $scope.listaEmpleados[0];
		});
	};

	$scope.dataHandler = function(data, callback){
		switch (data.status) {
			case 'OK':
				callback(data);
				break;
			case 'ERROR':
				$scope.panelResultado = {
					tipo: 'alert-danger',
					titulo: 'Error',
					mensaje: 'Se ha producido un error al guadar los datos del empleado.'
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

	$scope.seleccionar = function(empleado){
		$scope.empleado = empleado;
	};

	$scope.busqueda = function(){
		$scope.currentPage = 1;
		$scope.mostrarPaginacion = ($scope.search == '' || !angular.isDefined($scope.search));
	};

	$scope.controlDias = function(dias){
		if (dias == 'acum'){
			$scope.empleado.diasrestantes = 1095 - $scope.empleado.diasacum;
		} else {
			$scope.empleado.diasacum = 1095 - $scope.empleado.diasrestantes;
		}
	};

	$scope.guardar = function(){
		empleadosFactory.actualizarLicencia($scope.empleado, function(data){
			console.log(data);
			$scope.dataHandler(data, function(datos){
				$scope.panelResultado = {
					tipo: 'alert-success',
					titulo: 'Éxito',
					mensaje: 'Los datos del empleado se han actualizado correctamente.s'
				};
				$scope.cargaDatos();
			});
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
			}, 4000);
		})
	};

	$scope.cargaDatos();
}
