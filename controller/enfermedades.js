/**
 * Created by artiom on 05/12/14.
 */
function enfermedadesCtrl($scope, enfermedadesFactory, authFactory, $state, loginService, $timeout, dialogs){

	$scope.totalItems = 0;
	$scope.currentPage = 1;
	$scope.itemsPerPage = 10;
	$scope.search = '';

	$scope.listaEnfermedades = [];
	$scope.enfermedadesFiltradas = [];

	$scope.edicion = true;

	$scope.mostrarPaginacion = true;

	$scope.busqueda = function(){
		$scope.currentPage = 1;
		$scope.mostrarPaginacion = ($scope.search == '' || !angular.isDefined($scope.search));
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
					mensaje: 'Los datos no se han procesado correctamente.'
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

	$scope.seleccionar = function(enfermedad){
		$scope.enfermedad = enfermedad;
		$scope.edicion = true;
	};

	$scope.cargaDatos = function(){
		enfermedadesFactory.traerEnfermedades(function(data){
			$scope.dataHandler(data, function(datos){
				$scope.listaEnfermedades = datos.datos;
				$scope.totalItems = $scope.listaEnfermedades.length;
				$scope.enfermedad = $scope.listaEnfermedades[0];
			})
		})
	};

	$scope.guardar = function(){
		enfermedadesFactory.guardarEnfermedad($scope.enfermedad, function(data){
			$scope.dataHandler(data, function(datos){
				$scope.panelResultado = {
					tipo: 'alert-success',
					titulo: 'Modificación',
					mensaje: 'La enfermedad se ha guardado con éxito.'
				};
			});
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
				$scope.cargaDatos();
			}, 4000);
		})
	};

	$scope.alta = function(){
		enfermedadesFactory.altaEnfermedad($scope.enfermedad, function(data){
			$scope.dataHandler(data, function(datos){
				$scope.panelResultado = {
					tipo: 'alert-success',
					titulo: 'Alta',
					mensaje: 'La enfermedad se ha guardado correctamente.'
				};
			});
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
				$scope.cargaDatos();
			}, 4000);
		})
	};

	$scope.eliminar = function(){
		enfermedadesFactory.eliminarEnfermedad($scope.enfermedad, function(data){
			$scope.dataHandler(data, function(datos){
				$scope.panelResultado = {
					tipo: 'alert-success',
					titulo: 'Eliminar',
					mensaje: 'La enfermedad ha sido borrada con éxito.'
				};
			});
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
				$scope.search = '';
				$scope.mostrarPaginacion = true;
				$scope.currentPage = 1;
				$scope.cargaDatos();
			}, 4000);
		})
	};

	$scope.nuevaEnfermedad = function(){
		$scope.enfermedad = {
			codigo: '',
			enfermedad: ''
		};
		$scope.edicion = false;
	};

	$scope.cargaDatos();

}
