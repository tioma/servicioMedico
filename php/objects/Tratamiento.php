<?php

include_once 'Empleado.php';
include_once 'bd.php';
include_once 'TipoLicencia.php';
include_once 'busquedas.php';

class Tratamiento{
	//Propiedades//
	var $idTrat = 0;
	var $empleado;
	var $idEnfermedad;
	var $enfermedadAnterior;
	var $enfermedad;
	var $descripcion;
	var $fechaInicio;
	var $fechaAlta;
	var $fechaCambio;
	var $diasAsignados;
	var $diasAgregados;
	var $tipoLicencia;
	var $estado;
	//Base de datos//
	var $bd;
	//Manejo de errores de negocio//
	var $mensajeError;
	
	function Tratamiento(){
		$this->bd = new bd(); 
	}
	
	function porId($idTrat){
		$this->idTrat = $idTrat;

		$busqueda = new buscarTratamiento();
		$miTratamiento = $busqueda->porID($idTrat);
		
		$this->cargarDatosTratamiento($miTratamiento);
	}
	
	function porEmpleado($unEmpleado){
		$this->empleado = $unEmpleado;
		
		if ($this->empleado->tieneTratamientoEnCurso()){
			$tratamiento = pg_fetch_assoc($this->empleado->bd->datos);
			$this->cargarDatosTratamiento($tratamiento);
		}
	}
	
	function cargarDatosTratamiento($datos){
		$this->idEnfermedad = $datos['codenfermedad'];
		$this->enfermedad = $datos['enfermedad'];
		$this->descripcion = $datos['desctrat'];
		$this->fechaInicio = $datos['fechaini'];
		$this->fechaAlta = $datos['fechaalta'];
		$this->diasAsignados = $datos['diasactual'];
		
		switch ($datos['tipolic']){
			case 'CT':
				$this->tipoLicencia = new CortoTratamiento();
			break;
			case 'LT':
				$this->tipoLicencia = new LargoTratamiento();
			break;
			case 'MA':
				$this->tipoLicencia = new Maternidad();
				break;
			case 'A17G':
				$this->tipoLicencia = new Art17ConGoce();
				break;
			case 'A17S':
				$this->tipoLicencia = new Art17SinGoce();
				break;
			case 'ART9':
				$this->tipoLicencia = new Articulo9();
				break;
			case 'ACC':
				$this->tipoLicencia = new Accidente();
				break;
			case 'SL':
				$this->tipoLicencia = new SinLicencia();
				break;
		}
		
		$this->estado = $datos['descestadolic'];
		
		$empleado = new Empleado($datos['nro_legajo'], $datos['nombre']);
		
		$this->empleado = $empleado;
	}
	
	function setIdEnfermedad($unaEnfermedad){
		$this->enfermedadAnterior = $this->idEnfermedad;
		$this->idEnfermedad = $unaEnfermedad;
	}
	
	function setDescripcion($unaDescripcion){
		$this->descripcion = $unaDescripcion;
	}
	
	function setFechaInicio($unaFecha){
		$this->fechaInicio = $unaFecha;
	}
	
	function setFechaAlta($unaFecha){
		$this->fechaAlta = $unaFecha;
	}
	
	function setFechaCambio($unaFecha){
		$this->fechaCambio = $unaFecha;
	}
	
	function setDias($unaCantidad){
		$this->diasAsignados = $unaCantidad;
	}
	
	function setTipoLicencia($unaLicencia){
		$this->tipoLicencia = $unaLicencia;
	}
	
	function setEstado($unEstado){
		$this->estado = $unEstado;
	}
	
	function setEmpleado($unEmpleado){
		$this->empleado = $unEmpleado;
	}
	
	function agregarDias($unaCantidad){
		$this->diasAgregados = $unaCantidad;
		$this->diasAsignados += $unaCantidad;
	}
	
	private function validarTratamiento(){
		return $this->tipoLicencia->validarTratamiento($this);
	}
	
	function validarEmpleado(){
		if ($this->tipoLicencia->validarEmpleado($this->empleado)){
			return true;
		} else {
			$this->mensajeError = "Se le comunica que el empleado " . $this->empleado->nombre . " ha excedido el límite de 1095 días para licencias de largo tratamiento";
			return false;
		}
	}
	
	private function actualizarCabecera(){
		return $this->tipoLicencia->actualizarEmpleado($this->empleado, $this->diasAgregados, $this->fechaAlta);
	}
	
	function guardarTratamiento(){
		if ($this->validarTratamiento())
		{
			$this->diasAgregados = $this->diasAsignados;
			
			if ($this->actualizarCabecera()){
			
				$query = "INSERT INTO habagp.fichatratamientos (idtrat, nro_legajo, codenfermedad, descripcion, fechaini, fechaalta, diasactual, tipolic, estadolic) VALUES (";
				$query .= "nextval('habagp.seqidregsismed'), ";
				$query .= "'" . $this->empleado->legajo . "', ";
				$query .= "'" . $this->idEnfermedad . "', ";
				$query .= "'" . $this->descripcion . "', ";
				$query .= "'" . $this->fechaInicio . "', ";
				$query .= "'" . $this->fechaAlta . "', ";
				$query .= $this->diasAsignados . ", ";
				$query .= "'" . $this->tipoLicencia->codigo . "', ";
				$query .= "'" . $this->estado . "')";

				$this->bd->conectar();
			
				$this->bd->consultar($query);
			
				if ($this->bd->estado)
				{
					$query = "SELECT currval('habagp.seqidregsismed') as nuevotrat";
					$this->bd->consultar($query);
					$datos = $this->bd->datos[0];
					$this->idTrat = $datos['nuevotrat'];
					
					$query = "INSERT INTO habagp.tblevoltrat (id, legajo, idtrat, enfactual, fini, ffinal, descrip, dias) VALUES ";
					$query .= "(nextval('habagp.seqtblevoltrat'), '" . $this->empleado->legajo . "', " . $this->idTrat . ", ";
					$query .= "'" . $this->idEnfermedad . "', '" . $this->fechaInicio . "', '" . $this->fechaAlta . "', '" . $this->descripcion . "', " . $this->diasAgregados . ")";
				
					$this->bd->consultar($query);
				
					$this->bd->cerrarConexion();
				
					if ($this->bd->estado)
					{
						return true;
					}
					else
					{
						$this->mensajeError = $this->bd->mensaje;
						return false;				
					}
					
				}
				else
				{
					$this->mensajeError = $this->bd->mensaje;
					$this->bd->cerrarConexion();
					return false;				
				}
			}
			else {
				$this->mensajeError = "Ha ocurrido un error al actualizar la cabecera del tratamiento.";
				return false;
			}
		}
		else
		{
			$this->mensajeError = $this->tipoLicencia->mensajeError;
			return false;
		}
	}
	
	function guardarCambios(){
		if ($this->validarTratamiento()){
			
			if ($this->actualizarCabecera()){
				$query = "UPDATE habagp.fichatratamientos ";
				$query .= "SET codenfermedad = '" . $this->idEnfermedad . "', ";
				$query .= "descripcion = '" . $this->descripcion . "', ";
				$query .= "fechaalta = '" . $this->fechaAlta . "', ";
				$query .= "diasactual = " . $this->diasAsignados . ", ";
				$query .= "tipolic = '" . $this->tipoLicencia->codigo . "' ";
				$query .= "WHERE idtrat = " . $this->idTrat;
			
				$this->bd->conectar();
			
				$this->bd->consultar($query);
			
				if ($this->bd->estado)
				{
					$query = "INSERT INTO habagp.tblevoltrat (id, legajo, idtrat, enfant, enfactual, fini, ffinal, descrip, dias) VALUES ";
					$query .= "(nextval('habagp.seqtblevoltrat'), '" . $this->empleado->legajo . "', " . $this->idTrat . ", '" . $this->enfermedadAnterior . "', ";
					$query .= "'" . $this->idEnfermedad . "', '" . $this->fechaCambio . "', '" . $this->fechaAlta . "', '" . $this->descripcion . "', " . $this->diasAgregados . ")";
				
					$this->bd->consultar($query);
				
					$this->bd->cerrarConexion();
				
					if ($this->bd->estado)
					{
						return true;
					}
					else
					{
						$this->mensajeError = $this->bd->mensaje;
						return false;				
					}
				}
				else
				{
					$this->mensajeError = $this->bd->mensaje;
					$this->bd->cerrarConexion();
					return false;				
				}	
			}
			else {
				$this->mensajeError = "Ha ocurrido un error al actualizar la cabecera del tratamiento.";
				return false;
			}
		}
		else {
			$this->mensajeError = $this->tipoLicencia->mensajeError;
			return false;
		}
	}
	
	function darDeAlta(){
		$query = "UPDATE habagp.fichatratamientos SET estadolic = 'A' where idtrat = " . $this->idTrat;
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		
		if ($this->bd->estado){
			return $this->tipoLicencia->guardarDatos($this);
		}
		else {
			return false;
		} 
	}
	
	function esElUltimo(){
		$query = "SELECT max(idtrat) as id from habagp.fichatratamientos WHERE nro_legajo = '" . $this->empleado->legajo . "' AND tipolic='LT'";
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		
		$dato = $this->bd->datos[0];
		
		return $this->idTrat == $dato['id'];
	}
	
	function puedoEliminar(){
		return $this->tipoLicencia->puedoEliminar($this);
	}
	
	function eliminate(){
		if ($this->puedoEliminar()){
			$query = "DELETE FROM habagp.fichatratamientos WHERE idtrat = '" . $this->idTrat . "'";
			
			$this->bd->conectar();
			$this->bd->consultar($query);
			$this->bd->cerrarConexion();
			
			return $this->tipoLicencia->actualizarUltimaAusencia($this);
		}
		else {
			$this->mensajeError = "El tratamiento seleccionado no se ha podido eliminar";
			return false;
		}
	}
	
	function guardarOtrasLic($esAlta) {
		if ($esAlta){
			$query = "INSERT INTO habagp.otraslicencias values (nextval('habagp.seqtblotraslic'), '" . $this->empleado->legajo . "', '" . $this->tipoLicencia->codigo . "', '" . substr($this->fechaInicio, 0, 4) . "', " . $this->diasAsignados . ")";
		} else {
			$query = "INSERT INTO habagp.otraslicencias values (nextval('habagp.seqtblotraslic'), '" . $this->empleado->legajo . "', '" . $this->tipoLicencia->codigo . "', '" . substr($this->fechaInicio, 0, 4) . "', -" . $this->diasAsignados . ")";
		}
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		
		return $this->bd->estado;
	}
}

?>