<?php 

include_once 'bd.php';

class Enfermedad{
	//Propiedades//
	var $codEnfermedad;
	var $descripEnfermedad;
	//Base de datos//
	var $bd;
	//Manejo de errores de negocio//
	var $mensajeError;


	function Enfermedad(){
		$this->bd = new bd(); 
		$this->mensajeError = '';
	}
	
	function setCodEnfermedad($codEnfermedad){
		$this->codEnfermedad = $codEnfermedad;
	}
	
	function setDescripEnfermedad($descripEnfermedad){
		$this->descripEnfermedad = $descripEnfermedad;
	}
	
	function nuevaEnfermedad(){
		if (!$this->verificaQueExista()) {
			$query = "INSERT INTO habagp.enfermedades (codigo,enfermedad) VALUES (";
			$query = $query . "'" . $this->codEnfermedad . "', ";
			$query = $query . "'" . $this->descripEnfermedad . "')";

			$this->bd->conectar();
			$this->bd->consultar($query);
			$this->bd->cerrarConexion();
			
			return $this->bd->estado;
		}
		else {
			$this->mensajeError = "El codigo de la enfermedad ya existe";
			return false;
		}
	}

	function modificaEnfermedad(){
		if ($this->verificaQueExista()) {
			$query = "UPDATE habagp.enfermedades set ";
			$query = $query . "enfermedad = '" . $this->descripEnfermedad . "' ";
			$query = $query . "WHERE codigo = '" . $this->codEnfermedad . "'";

			$this->bd->conectar();
			$this->bd->consultar($query);
			$this->bd->cerrarConexion();
			
			return $this->bd->estado;
		}
		else {
			$this->mensajeError = "La enfermedad seleccionada es invalida";
			return false;
		}
	}

	function eliminaEnfermedad(){
		if ($this->verificaQueExista()) {
			$query = "DELETE FROM habagp.enfermedades ";
			$query = $query . "WHERE codigo = '" . $this->codEnfermedad . "'";

			$this->bd->conectar();
			$this->bd->consultar($query);
			$this->bd->cerrarConexion();
			
			return $this->bd->estado;
		}
		else {
			$this->mensajeError = "La enfermedad seleccionada es invalida";
			return false;
		}
	}

	function verificaQueExista(){
		$query = "SELECT * FROM habagp.enfermedades WHERE codigo = ";
		$query = $query . "'" . $this->codEnfermedad . "'";

		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		
		return ($this->bd->cantidad == 1);
	}
	
	function resultado(){
		return $this->bd->estado;
	}
}
?>