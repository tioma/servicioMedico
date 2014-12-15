/**
 * Created by artiom on 12/11/14.
 */
function tratamientosCtrl($rootScope, $scope, tratamientosFactory, enfermedadesFactory, empleadosFactory, $timeout, $state, authFactory, loginService, dialogs){
	"use strict";

	$scope.verNuevoTratamiento = false;
	$scope.verFichaTratamiento = false;
	$scope.tratamiento = {};

	$scope.fechaCambio = new Date();
	$scope.diasAgregados = 0;
	$scope.diasTranscurridos = 0;
	$scope.nuevaAlta = '';
	$scope.nuevaEnfermedad = {};

	$scope.listaEmpleados = [];

	$scope.mostrarPanelResultado = false;
	$scope.panelResultado = {
		tipo: '',
		titulo: '',
		mensaje: ''
	};

	empleadosFactory.traerEmpleados(function(data){
		$scope.listaEmpleados = data;
	});

	enfermedadesFactory.traerEnfermedades(function(data){
		$scope.listaEnfermedades = data.datos
	});

	tratamientosFactory.traerTiposLicencias(function(data){
		$scope.listaTiposLicencias = data;
	});

	$scope.$on('cargarFicha', function(event, data){
		$scope.dataHandler(data, function(datos){
			$scope.cargarFicha(datos.datos);
		})
	});

	$scope.$on('error', function(event, data){
		$scope.dataHandler(data, function(data){})
	});

	$scope.esconderPanel = function(){
		$scope.mostrarPanelResultado = false;
	};

	$scope.actualizarDias = function(tipo){
		var fechaRestar = new Date($scope.fechaInicio);
		$scope.diasAgregados =  Math.ceil((((($scope.nuevaAlta - fechaRestar)/1000)/60)/60)/24);
		if (tipo == 'alta'){
			$scope.diasAgregados += 1;
		}
	};

	$scope.actualizarFecha = function(tipo){
		var altaActual = new Date($scope.fechaInicio);
		var agregarDias = parseInt($scope.diasAgregados);
		if (tipo == 'alta'){
			agregarDias -= 1;
		}
		if ($scope.diasAgregados != '' && $scope.diasAgregados != null && angular.isDefined($scope.diasAgregados)){
			$scope.nuevaAlta = new Date(altaActual.getFullYear(), altaActual.getMonth(), altaActual.getDate() + agregarDias);
		} else {
			$scope.nuevaAlta = new Date(altaActual);
		}
	};


	$scope.openDate = function(event){
		$rootScope.openDate(event);
	};

	$scope.enfermedadElegida = function(selected){
		if (angular.isDefined(selected)){
			$scope.filtros.enfermedad = selected.title;
			$scope.cargaDatos();
		}
	};

	$scope.cambioEnfermedad = function(selected){
		if (angular.isDefined(selected)){
			$scope.nuevaEnfermedad = selected.originalObject;
		}
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
					mensaje: data.data.mensajeError
				};
				break;
			case 'WARNING':
				$scope.panelResultado = {
					tipo: 'alert-warning',
					titulo: 'Atención',
					mensaje: 'El empleado seleccionado ha superado sus días totales de licencia.'
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

	$scope.cargaEvolucion = function(){
		tratamientosFactory.traerEvolucion($scope.tratamiento, function(data){
			$scope.dataHandler(data, function(datos){
				$scope.tratamiento.evolucion = datos.datos;
			})
		});
	};

	$scope.puedoEliminar = function(){
		tratamientosFactory.puedoEliminarTratamiento($scope.tratamiento, function(data){
			$scope.tratamiento.puedoEliminar = (data == 'true');
		})
	};

	$scope.cargarFicha = function(tratamiento){
		var fechaInicio;
		var fechaFin = new Date();

		$scope.tratamiento = tratamiento;
		$scope.nuevaAlta = new Date(tratamiento.fechaalta);

		fechaInicio = new Date(tratamiento.fechaini);
		$scope.cargaEvolucion();
		$scope.puedoEliminar();
		$scope.diasTranscurridos =  Math.floor(((((fechaFin - fechaInicio)/1000)/60)/60)/24);
		$scope.verFichaTratamiento = true;
		$scope.fechaInicio = $scope.tratamiento.fechaalta;

		$scope.listaEnfermedades.forEach(function(enfermedad){
			if (enfermedad.enfermedad == tratamiento.enfermedad){
				$scope.nuevaEnfermedad = enfermedad;
			}
		});
	};

	$scope.volver = function(){
		$scope.cargaDatos();
		$scope.verFichaTratamiento = false;
		$scope.verNuevoTratamiento = false;
	};

	$scope.guardarCambios = function(){
		if ($scope.diasAgregados != '' && $scope.diasAgregados != null && angular.isDefined($scope.diasAgregados) && parseInt($scope.diasAgregados) > 0){
			var postData = {
				nuevaAlta: $scope.nuevaAlta,
				nuevaEnfermedad: $scope.nuevaEnfermedad,
				fechaCambio: $scope.fechaCambio,
				diasAgregados: $scope.diasAgregados,
				tratamiento: $scope.tratamiento
			};
			tratamientosFactory.guardarTratamiento(postData, function(data){
				$scope.dataHandler(data, function(datos){
					$scope.panelResultado = {
						tipo: 'alert-success',
						titulo: 'Éxito',
						mensaje: 'Los datos se han guardado correctamente.'
					};
					$scope.cargaEvolucion();
					$scope.diasAgregados = 0;
				});
				$scope.mostrarPanelResultado = true;
				$timeout(function(){
					$scope.mostrarPanelResultado = false;
				}, 8000);
			});
		} else {
			$scope.panelResultado = {
				tipo: 'alert-danger',
				titulo: 'Error',
				mensaje: 'La cantidad de días agregados debe definirse y ser mayor a 0.'
			};
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
			}, 8000);
		}
	};

	$scope.guardarTratamiento = function(){
		if ($scope.comprobarDatos()){
			$scope.tratamiento.fechaalta = $scope.nuevaAlta;
			$scope.tratamiento.diasotorgados = $scope.diasAgregados;
			tratamientosFactory.nuevoTratamiento($scope.tratamiento, function(data){
				$scope.dataHandler(data, function(datos){
					$scope.diasAgregados = 0;
					$scope.verNuevoTratamiento = false;
					$scope.mostrarFicha(datos.data);
				})
			})
		}
	};

	$scope.setearInterfaz = function(){
		$scope.nuevaAltaEnfermedad = '0';
		tratamientosFactory.detallesTipoLicencia($scope.tratamiento.tipolic, function(data){
			$scope.tipoLicencia = data;
			if ($scope.tratamiento.tipolic != 'CT' && $scope.tratamiento.tipolic != 'LT'){
				$scope.tratamiento.enfermedad.codigo = $scope.tipoLicencia.idEnfermedad;
				$scope.nuevaAltaEnfermedad = $scope.tipoLicencia.idEnfermedad;
			} else {
				$scope.tratamiento.enfermedad.codigo = '';
				$scope.nuevaAltaEnfermedad = '';
			}
		})
	};

	$scope.darDeAlta = function(){
		var respuesta = dialogs.confirm('Dar de alta', 'Se dará de alta el tratamiento, ¿confirma la operación?');
		respuesta.result.then(function(){
			tratamientosFactory.altaTratamiento($scope.tratamiento, function(data){
				$scope.dataHandler(data, function(datos){
					$scope.tratamiento.estadolic = 'A';
					$scope.tratamiento.descestadolic = 'De Alta';
					$scope.panelResultado = {
						tipo: 'alert-success',
						titulo: 'Éxito',
						mensaje: 'El tratamiento ha sido dado de alta.'
					};
				});
				$scope.mostrarPanelResultado = true;
				$timeout(function(){
					$scope.mostrarPanelResultado = false;
					$scope.volver();
				}, 4000);
			});
		})
	};

	$scope.eliminarTratamiento = function(){
		var respuesta = dialogs.confirm('Borrar', 'El tratamiento será eliminado, ¿confirma la operación?');
		respuesta.result.then(function(){
			tratamientosFactory.eliminarTratamiento($scope.tratamiento, function(data){
				$scope.dataHandler(data, function(datos){
					$scope.panelResultado = {
						tipo: 'alert-success',
						titulo: 'Borrar',
						mensaje: 'El tratamiento ha sido eliminado.'
					};
				})
			});
			$scope.cargaDatos();
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
				$scope.cargaDatos();
				$scope.verFichaTratamiento = false;
			}, 4000);
		});
	};

	$scope.nuevoTratamiento = function(){
		$scope.verFichaTratamiento = false;
		$scope.verNuevoTratamiento = true;
		$scope.fechaInicio = new Date();
		$scope.nuevaAlta = '';
		$scope.tratamiento = {
			empleado: {
				legajo: '',
				nombre: ''
			},
			enfermedad: {
				codigo: '',
				enfermedad: ''
			},
			tipolic: '',
			fechaini: $scope.fechaInicio,
			fechaalta: '',
			diasotorgados: 0,
			estadolic: '',
			desctrat: ''
		};
		$scope.diasAgregados = 0;
		$scope.nuevaAlta = '';
	};

	$scope.nuevoEmpleadoElegido = function(selected){
		if (angular.isDefined(selected)){
			$scope.tratamiento.empleado = selected.originalObject;
		}
	};

	$scope.nuevaEnfermedadElegida = function(selected){
		if (angular.isDefined(selected)){
			$scope.tratamiento.enfermedad = selected.originalObject;
		}
	};

	$scope.comprobarDatos = function(){
		var error = false;
		$scope.panelResultado = {
			tipo: 'alert-danger',
			titulo: 'Error',
			mensaje: 'Faltan datos requeridos para guardar el tratamiento.'
		};
		if ($scope.tratamiento.estadolic == ''){
			$scope.panelResultado.mensaje = 'No se ha definido el estado del tratamiento.';
			error = true;
		}
		if ($scope.tratamiento.enfermedad.codigo == ''){
			$scope.panelResultado.mensaje = 'Los datos de la enfermedad están vacíos o no son válidos.';
			error = true;
		}
		if (angular.isDefined($scope.tipoLicencia)){
			if ($scope.tratamiento.tipolic == 'LT'){
				if ($scope.diasAgregados <= 15){
					$scope.panelResultado.mensaje = 'Los días otorgados son inferiores a la cantidad mínima que requiere el tipo de licencia.';
					error = true;
				}
			}
			if ($scope.diasAgregados > $scope.tipoLicencia.diasMaximo){
				$scope.panelResultado.mensaje = 'Los días otorgados superan el máximo permitido para el tipo de licencia seleccionado.';
				error = true;
			}
			if ($scope.diasAgregados <= 0 || $scope.nuevaAlta == ''){
				$scope.panelResultado.mensaje = 'La fecha de alta no se encuentra definida o los días otorgados no representan un valor válido.';
				error = true;
			}
		} else {
			$scope.panelResultado.mensaje = 'No se ha seleccionado un tipo de licencia.';
			error = true;
		}
		if ($scope.tratamiento.empleado.legajo == ''){
			$scope.panelResultado.mensaje = 'Los datos del empleado están vacíos o no son válidos.';
			error = true;
		}
		if (error){
			$scope.mostrarPanelResultado = true;
			$timeout(function(){
				$scope.mostrarPanelResultado = false;
			}, 4000);
		}

		return !error;
	};

}
