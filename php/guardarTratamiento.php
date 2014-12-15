<?php

include_once 'objects/Tratamiento.php';
include_once 'util.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){
		$data = get_post();

		$idTrat = $data['tratamiento']['idtrat'];

		$tratamiento = new Tratamiento();
		$tratamiento->porId($idTrat);

		$enfermedad = $data['nuevaEnfermedad']['codigo'];

		$fechaCambio = $data['fechaCambio'];
		$nuevaAlta = $data['nuevaAlta'];

		$diasAgregados = $data['diasAgregados'];
		if ($diasAgregados > 0){
			$fechaCambio = strtotime($tratamiento->fechaAlta);
			$fechaCambio += 86400;
			$fechaCambio = date("Y-m-d", $fechaCambio);
		}

		$descripcion = $data['tratamiento']['desctrat'];

		if ($tratamiento->tipoLicencia->puedeCambiar()){
			$nuevoTipoLicencia = $data['tratamiento']['tipolic'];
			if ($nuevoTipoLicencia == "LT"){
				$tipoLicencia = new LargoTratamiento();
				$tratamiento->setTipoLicencia($tipoLicencia);
				$tratamiento->empleado->actualizarCabecera($tratamiento->diasAsignados, $nuevaAlta);
			} else {
				$mensaje = "No se pudo realizar el cambio de licencia";
			}
		}

		$tratamiento->agregarDias($diasAgregados);
		$tratamiento->setFechaAlta($nuevaAlta);
		$tratamiento->setIdEnfermedad($enfermedad);
		$tratamiento->setFechaCambio($fechaCambio);
		$tratamiento->setDescripcion($descripcion);

		if ($tratamiento->guardarCambios()){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}

		if (!$tratamiento->validarEmpleado()){
			$response['status'] = 'WARNING';
		}

		$response['data'] = $tratamiento;
	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
};

send_response($response);

