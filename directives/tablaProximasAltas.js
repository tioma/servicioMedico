/**
 * Created by artiom on 02/12/14.
 */
myapp.directive('tablaProximasAltas', function(){
	return {
		restrict:		'E',
		templateUrl:	'view/tabla.proximas.altas.html',
		controller: ['$scope', 'tratamientosFactory', function($scope, tratamientosFactory){
			$scope.listaTratamientos = [];
			$scope.tratamientosFiltrados = [];
			$scope.reverse = false;
			$scope.predicate = 'resto';
			$scope.totalItems = 0;
			$scope.currentPage = 1;
			$scope.itemsPerPage = 10;

			$scope.panelMensaje = {
				tipo: 'panel-info',
				titulo: 'Pŕoximas altas',
				mensaje: 'No se hallaron tratamientos que deban ser dados de alta en los próximos días.'
			};

			$scope.manejador = function(data, callback){
				if (data.status == 'OK'){
					callback(data);
				} else {
					$scope.$emit('error', data);
				}
			};

			$scope.ordenarPor = function(filtro){
				if ($scope.predicate == filtro){
					$scope.reverse = !$scope.reverse;
				}
				$scope.predicate = filtro;
			};

			$scope.cargaDatos = function(){
				tratamientosFactory.proximasAltas(function(data){
					$scope.manejador(data, function(datos){
						$scope.listaTratamientos = datos.datos;
						$scope.totalItems = $scope.listaTratamientos.length;
					})
				})
			};

			$scope.mostrarFicha = function(tratamiento){
				tratamientosFactory.tratamientoPorId(tratamiento.idtrat, function(data){
					$scope.$emit('cargarFicha', data);
				});
			};

			$scope.cargaDatos();
		}]
	}
});