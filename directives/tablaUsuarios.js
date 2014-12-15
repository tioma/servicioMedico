/**
 * Created by artiom on 02/12/14.
 */
myapp.directive('tablaUsuarios', function(){
	return {
		restrict:		'E',
		templateUrl:	'view/tabla.usuarios.html',
		controller: ['$rootScope', '$scope', 'authFactory', '$timeout', 'dialogs', function($rootScope, $scope, authFactory, $timeout, dialogs){
			$scope.listaUsuarios = [];
			$scope.usuariosFiltrados = [];
			$scope.totalItems = 0;
			$scope.currentPage = 1;
			$scope.itemsPerPage = 7;
			$scope.usuario = {};
			$scope.panelMensaje = {
				tipo: '',
				titulo: '',
				mensaje: ''
			};
			$scope.mostrarPanelResultado = false;

			$scope.manejador = function(data, callback){
				switch (data.status){
					case 'OK':
						callback(data);
						break;
					case 'ERROR':
						$scope.panelResultado = {
							tipo: 'alert-danger',
							titulo: 'Error',
							mensaje: 'Se ha producido un error al intentar guardar los cambios del usuario.'
						};
						break;
					default:
						$scope.$emit('error', data);
						break
				}
			};

			$scope.esconderPanel = function(){
				$scope.mostrarPanelResultado = false;
			};

			$scope.cargaDatos = function(){
				authFactory.traerUsuarios(function(data){
					$scope.manejador(data, function(datos){
						$scope.listaUsuarios = datos.datos;
						$scope.totalItems = $scope.listaUsuarios.length;
						$scope.usuario = $scope.listaUsuarios[0];
					})
				})
			};

			$scope.seleccionar = function(usuario){
				$scope.usuario = usuario;
			};

			$scope.eliminar = function(){
				var respuesta = dialogs.confirm('Eliminar', 'Se eliminará el usuario seleccionado, ¿confirma la operación?');
				respuesta.result.then(function(){
					authFactory.eliminarUsuario($scope.usuario, function(data){
						$scope.dataHandler(data, function(datos){
							$scope.panelResultado = {
								tipo: 'alert-info',
								titulo: 'Éxito',
								mensaje: 'El usuario ha sido eliminado del sistema.'
							};
						});
						$scope.mostrarPanelResultado = true;
						$timeout(function(){
							$scope.mostrarPanelResultado = false;
							$scope.cargaDatos();
						}, 4000);
					});
				})
			};

			$scope.guardar = function(){
				authFactory.guardarCambios($scope.usuario, function(data){
					$scope.manejador(data, function(datos){
						$scope.panelResultado = {
							tipo: 'alert-success',
							titulo: 'Éxito',
							mensaje: 'Se ha guardado la configuración para el usuario ' + $scope.usuario.usuario + '.'
						};
					});
					$scope.mostrarPanelResultado = true;
					$timeout(function(){
						$scope.mostrarPanelResultado = false;
						$scope.cargaDatos();
					}, 4000);
				})
			};

			$scope.cargaDatos();
		}]
	}
});
