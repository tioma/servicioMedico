<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 28/11/14
 * Time: 10:38
 */

include_once 'util.php';
include_once 'objects/Tratamiento.php';
include_once 'objects/busquedas.php';

session_start();

if (isset($_SESSION['permisos']['tratamientos'])){
	if ($_SESSION['permisos']['tratamientos']){
		$data = get_post();

		$tratamiento = new Tratamiento();
		$empleado = new Empleado(trim($data['empleado']['legajo']), $data['empleado']['nombre']);

		switch ($data['tipolic']){
			case "CT":
				$licencia = new CortoTratamiento();
				break;
			case "LT":
				$licencia = new LargoTratamiento();
				break;
			case "MA":
				$licencia = new Maternidad();
				break;
			case "A17G":
				$licencia = new Art17ConGoce();
				break;
			case "A17S":
				$licencia = new Art17SinGoce();
				break;
			case "ART9":
				$licencia = new Articulo9();
				break;
			case "ACC":
				$licencia = new Accidente();
				break;
			case "SL":
				$licencia = new SinLicencia();
				break;
		}

		$tratamiento->setEmpleado($empleado);
		$tratamiento->setTipoLicencia($licencia);
		$tratamiento->setDias($data['diasotorgados']);
		$tratamiento->setFechaInicio($data['fechaini']);
		$tratamiento->setFechaAlta($data['fechaalta']);
		$tratamiento->setEstado($data['estadolic']);
		$tratamiento->setIdEnfermedad($data['enfermedad']['codigo']);
		$tratamiento->setDescripcion($data['desctrat']);

		if ($tratamiento->guardarTratamiento()){
			$response['status'] = 'OK';
		} else {
			$response['status'] = 'ERROR';
		}

		if (!$tratamiento->validarEmpleado()){
			$response['status'] = 'WARNING';
		}

		$busqueda = new buscarTratamiento();

		$response['data'] = $busqueda->porID($tratamiento->idTrat);
	} else {
		$response['status'] = 'FORBIDDEN';
	}
} else {
	$response['status'] = 'NOTLOGGED';
};

send_response($response);

