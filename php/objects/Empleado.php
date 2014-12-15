<?php

include_once 'bd.php';

class Empleado{
	//Propiedades
	var $legajo;
	var $nombre;
	var $diasAcumulados;
	var $diasRestantes;
	var $ultimaAusencia;
	var $tratamientoEnCurso;
	//Base de datos
	var $bd;
	
	function Empleado($legajo, $nombre){
		$this->legajo = $legajo;
		$this->nombre = $nombre;
		
		$this->bd = new bd();
		
		$this->obtenerDiasAcumulados();
	}
	
	private function obtenerDiasAcumulados(){
		$query = "SELECT diasacum, diasrestantes, ultausencia::date FROM habagp.tratcabecera WHERE legajo = '" . $this->legajo . "'";
		
		$this->bd->conectar();
		
		$this->bd->consultar($query);
		
		if ($this->bd->estado){
			$datos = $this->bd->datos[0];
			
			$this->diasAcumulados = $datos['diasacum'];
			$this->diasRestantes = $datos['diasrestantes'];
			$this->ultimaAusencia = $datos['ultausencia'];
		}
		
		$this->bd->cerrarConexion();
	}
	
	function setDiasAcum($dias){
		$this->diasAcumulados = $dias;
		$this->diasRestantes = 1095 - $dias;
	}
	
	function tieneTratamientoEnCurso(){
		$query = "SELECT idtrat FROM habagp.fichatratamientos WHERE estadolic = 'C' AND nro_legajo = '" . $this->legajo . "'";
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		
		if ($this->bd->cantidad > 0){
			$datos = $this->bd->datos[0];
			
			$this->tratamientoEnCurso = $datos['idtrat'];
			return true;
		}
		else{
			return false;
		}
	}
	
	function obtenerDiasArticulo17($tipoLicencia){
		$dias = 0;
		
		$query = "SELECT sum(dias) as acum FROM habagp.otraslicencias WHERE legajo = '" . $this->legajo . "' AND tipolic = '" . $tipoLicencia . "' AND anio = '" . date("Y") . "' GROUP BY idotraslic";
		
		//Al aplicarse un sum siempre al menos se traer� una fila aunque est� vac�a.
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		
		if ($this->bd->estado){
			$datos = $this->bd->datos[0];
			$dias = $datos['acum'];
			
			if ($dias == ''){
				$dias = 0;
			}
		}
		
		return $dias;
	}
	
	function actualizarCabecera($dias, $ultimaAusencia) {
		$this->diasAcumulados += $dias;
		$this->diasRestantes -= $dias;
		$this->ultimaAusencia = $ultimaAusencia;
		
		if ($ultimaAusencia == ""){
			$query = "UPDATE habagp.tratcabecera SET diasacum = " . $this->diasAcumulados . ", diasrestantes = " . $this->diasRestantes . ", ultausencia = NULL ";
		}else{
			$query = "UPDATE habagp.tratcabecera SET diasacum = " . $this->diasAcumulados . ", diasrestantes = " . $this->diasRestantes . ", ultausencia = '" . $this->ultimaAusencia . "' ";
		}
		$query .= "WHERE legajo = '" . $this->legajo . "'";
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();
		if ($this->bd->estado)
		{
			$this->obtenerDiasAcumulados();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function actualizarUltimaAusencia($dias){
		$query = "SELECT max(fechaalta) as fecha FROM habagp.fichatratamientos WHERE nro_legajo = '" . $this->legajo . "' AND tipolic = 'LT'";
		
		//Al aplicarse una funci�n en el select siempre al menos va a traer una fila
		//aunque no haya resultado
		
		$this->bd->conectar();
		$this->bd->consultar($query);
		
		$ausencia = $this->bd->datos[0];
		$fecha_aus = $ausencia['fecha'];
		
		if ( $fecha_aus != ''){
			
			$query = "UPDATE habagp.tratcabecera SET ";
			$query .= "diasacum = diasacum - " . $dias . ", ";
			$query .= "diasrestantes = diasrestantes + " . $dias . ", ";
			$query .= "ultausencia = '" . $fecha_aus . "' ";
			$query .= "WHERE legajo='" . $this->legajo . "'";
		}
		else {
			
			$query = "UPDATE habagp.tratcabecera SET ";
			$query .= "diasacum = diasacum - " . $dias . ", ";
			$query .= "diasrestantes = diasrestantes + " . $dias . ", ";
			$query .= "ultausencia = null ";
			$query .= "WHERE legajo='" . $this->legajo . "'";
		}
		
		$this->bd->consultar($query);
		
		$query = "update habagp.tratcabecera ";
		$query .= " set diasacum=0, diasrestantes=1095,ultausencia=null ";
		$query .= " where ultausencia is not null and ";
		$query .= " date_part('days',now() - ultAusencia)>=1095 and legajo='" . $this->legajo . "'";

		$this->bd->consultar($query);
		$this->bd->cerrarConexion();

		return $this->bd->estado;
	}
	
}