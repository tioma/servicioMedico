<?php

include_once 'Tratamiento.php';
include_once 'Empleado.php';

abstract class TipoLicencia{
	//Propiedades
	var $codigo;
	var $diasMaximo;
	var $mensajeError;
	var $idEnfermedad = "";
	
	function validarTratamiento($untratamiento){
		return $untratamiento->diasAsignados <= $this->diasMaximo;
	}
	
	function validarEmpleado($unEmpleado){
		return true;
	}
	
	function puedeCambiar(){
		return false;
	}
	
	function actualizarEmpleado($unEmpleado, $diasAgregados, $ultimaAusencia){
		return true;
	}
	
	function puedoEliminar($unTratamiento){
		return trim($unTratamiento->estado) == "Con licencia";
	}
	
	function actualizarUltimaAusencia($unTratamiento){
		return true;
	}
	
	function guardarDatos($unTratamiento){
		return true;
	}
}

//Licencia de Largo tratamiento//
class LargoTratamiento extends TipoLicencia{
	var $diasMinimo = 15;
	
	function LargoTratamiento(){
		$this->codigo = "LT";
		$this->diasMaximo = 1095;
	}
	
	function validarTratamiento($unTratamiento){
		return $unTratamiento->diasAsignados >= $this->diasMinimo;
	}
	
	function validarEmpleado($unEmpleado){
		return $unEmpleado->diasAcumulados < $this->diasMaximo;
	}
	
	function actualizarEmpleado($unEmpleado, $diasAgregados, $ultimaAusencia){
		return $unEmpleado->actualizarCabecera($diasAgregados, $ultimaAusencia);
	}
	
	function puedoEliminar($unTratamiento){
		return $unTratamiento->esElUltimo();
	}
	
	function actualizarUltimaAusencia($unTratamiento){
		return $unTratamiento->empleado->actualizarUltimaAusencia($unTratamiento->diasAsignados);
	}
}

//Licencia de corto tratamiento//
class CortoTratamiento extends TipoLicencia{
	
	function CortoTratamiento(){
		$this->codigo = "CT";
		$this->diasMaximo = 14;
		$this->mensajeError = "El tratamiento excede la cantidad de d&iacute;as permitidos para este tipo de licencia";
	}
	
	function puedeCambiar(){
		return true;
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
}

//Licencia por maternidad//
class Maternidad extends TipoLicencia{
	
	function Maternidad(){
		$this->codigo= "MA";
		$this->diasMaximo = 100;
		$this->mensajeError = "El tratamiento excede la cantidad de d&iacute;as permitidos para este tipo de licencia";
		$this->idEnfermedad = "00MA";
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic();
	}
}

//Licencia Art. 17 con goce de sueldo//
class Art17ConGoce extends TipoLicencia{
	
	function Art17ConGoce(){
		$this->codigo="A17G";
		$this->diasMaximo = 20;
		$this->mensajeError = "Se ha excedido la cantidad anual de d&iacute;as para este tipo de licencia";
		$this->idEnfermedad = "A17G";
	}
	
	function validarTratamiento($untratamiento){
		$diasAcumulados = $untratamiento->empleado->obtenerDiasArticulo17($this->codigo) + $untratamiento->diasAsignados;
		return $diasAcumulados <= $this->diasMaximo;
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic(true);
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
	
	function actualizarUltimaAusencia($unTratamiento){
		return $unTratamiento->guardarOtrasLic(false);
	}
}

//Licencia Art. 17 sin goce de sueldo//
class Art17SinGoce extends TipoLicencia{
	
	function Art17SinGoce(){
		$this->codigo="A17S";
		$this->diasMaximo = 10;
		$this->mensajeError = "Se ha excedido la cantidad anual de d&iacute;as para este tipo de licencia";
		$this->idEnfermedad = "A17S";
	}
	
	function validarTratamiento($untratamiento){
		$diasAcumulados = $untratamiento->empleado->obtenerDiasArticulo17($this->codigo) + $untratamiento->diasAsignados;
		return $diasAcumulados <= $this->diasMaximo;
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic(true);
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
	
	function actualizarUltimaAusencia($unTratamiento){
		return $unTratamiento->guardarOtrasLic(false);
	}
	
}

//Licencia Art. 9 (Paternidad)
class Articulo9 extends TipoLicencia{
	
	function Articulo9(){
		$this->codigo = "ART9";
		$this->diasMaximo = 5;
		$this->mensajeError = "El tratamiento excede la cantidad de d&iacute;as permitidos para este tipo de licencia";
		$this->idEnfermedad = "00PA";
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic();
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
	
	function actualizarUltimaAusencia($unTratamiento){
		return $unTratamiento->guardarOtrasLic(false);
	}
}

//Licencia por accidentes
class Accidente extends TipoLicencia{
	
	function Accidente(){
		$this->codigo = "ACC";
		$this->diasMaximo = 3650;
		$this->mensajeError = "El tratamiento excede la cantidad de d&iacute;as permitidos para este tipo de licencia";
		$this->idEnfermedad = "00AC";
	}
	
	function validarTratamiento($untratamiento){
		return true;
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic();
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
}

//Sin licencia
class SinLicencia extends TipoLicencia{
	
	function SinLicencia(){
		$this->codigo = "SL";
		$this->diasMaximo = 0;
		$this->idEnfermedad = "6000";
	}
	
	function validarTratamiento($untratamiento){
		return true;
	}
	
	function guardarDatos($unTratamiento){
		return $unTratamiento->guardarOtrasLic();
	}
	
	function puedoEliminar($unTratamiento){
		return true;
	}
}

?>