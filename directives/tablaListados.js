/**
 * Created by artiom on 09/12/14.
 */
myapp.directive('tablaListados', function(){
	return {
		restrict:		'E',
		templateUrl:	'view/tabla.listados.html',
		controller: ['$rootScope', '$scope', 'tratamientosFactory', function($rootScope, $scope, tratamientosFactory){
			$scope.totalItems = 0;

			$scope.listaTratamientos = [];
			$scope.tratamientosFiltrados = [];
			$scope.listaTiposLicencias = [];
			$scope.reverse = false;
			$scope.predicate = 'nombre';
			$scope.totalItems = 0;
			$scope.currentPage = 1;
			$scope.itemsPerPage = 10;

			$scope.pagina = {
				limite: 10,
				offset: 0
			};

			$scope.filtros = {
				nombre: '',
				legajo: '',
				enfermedad: '',
				inicio: '',
				fechaalta: '',
				estado: '',
				tipoLicencia: ''
			};

			$scope.panelMensaje = {
				tipo: 'panel-info',
				titulo: 'Tratamientos',
				mensaje: 'No se encontraron tratamientos para los filtros seleccionados.'
			};

			$scope.$on('cambioPagina', function(event, data){
				$scope.currentPage = data;
				$scope.cargaDatos();
			});

			$scope.hitEnter = function(evt){
				if(angular.equals(evt.keyCode,13) && !$scope.verFichaTratamiento)
					$scope.cargaDatos();
			};

			$scope.manejador = function(data, callback){
				if (data.status == 'OK'){
					callback(data);
				} else {
					$scope.$emit('error', data);
				}
			};

			$scope.filtrado = function(filtro, contenido){
				$scope.currentPage = 1;
				switch (filtro){
					case 'nombre':
						$scope.filtros.nombre = contenido;
						break;
					case 'legajo':
						$scope.filtros.legajo = contenido;
						break;
					case 'enfermedad':
						$scope.filtros.enfermedad = contenido;
						break;
					case 'inicio':
						$scope.filtros.inicio = contenido;
						break;
					case 'fechaalta':
						$scope.filtros.fechaalta = contenido;
						break;
					case 'estado':
						$scope.filtros.estado = contenido;
						break;
					case 'tipoLicencia':
						$scope.filtros.tipoLicencia = contenido;
						break;
				}
				$scope.cargaDatos();
			};

			$scope.ordenarPor = function(filtro){
				if ($scope.predicate == filtro){
					$scope.reverse = !$scope.reverse;
				}
				$scope.predicate = filtro;
			};

			$scope.cargaDatos = function(){
				$scope.listaTratamientos = [];
				$scope.pagina.offset = ($scope.currentPage - 1) * $scope.pagina.limite;
				tratamientosFactory.generarListados($scope.filtros, function(data){
					$scope.manejador(data, function(datos){
						$scope.listaTratamientos = datos.datos;
						$scope.totalItems = $scope.listaTratamientos.length;
					});
				});
			};

			$scope.mostrarFicha = function(tratamiento){
				var data = {
					status: 'OK',
					datos: tratamiento
				};
				$scope.$emit('cargarFicha', data);
			};

			$scope.cargaDatos();
		}]
	}
});
