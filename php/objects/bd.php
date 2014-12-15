<?php
include_once 'bdConfig.php';

class bd {
	//Propiedades
	var $connectionString;
	var $conexion;
	var $sql;
	var $datos;
	var $ultimoId;
	var $estado = true;
	var $cantidad;
	var $mensaje;

	//Constructor
	function bd(){
		$bdConfig = new bdConfig();
		$this->connectionString = $bdConfig->connectionString();
	}

	//Metodos ---------------------------------------------------------------
	function conectar(){
		$this->conexion = new PDO($this->connectionString);
		//$this->conexion = pg_connect($this->connectionString) or die("No se pudo conectar a la base");
		return $this->conexion;
	}
	//-----------------------------------------------------------------------
	function consultar($sql){
		$resultado = null;
		//asigno variables 
		$this->sql = $sql;
		// si existe la conexion y $sql no esta vacio, ejecuta la consulta
		if( $this->conexion && $this->sql != '' ) {
			$this->datos = $this->conexion->query($this->sql)->fetchAll(PDO::FETCH_ASSOC);
			//$this->datos = pg_query( $this->conexion, $this->sql ) ;

			// si hay un objeto de resultado valido
			$this->cantidad		= count($this->datos);

			if( $this->datos > 0){
				$this->estado		= true ;
				$this->mensaje		= "Ok";

				// si no hay un objeto de resultado valido
			} else {
				$this->cantidad		= 0;
				$this->estado		= false;
				$this->mensaje		= "Error en la consulta SQL";
			}
			// sino no ejecuta la consulta
		}else{
			$this->estado = false ;
			if (!$this->conexion){
				$this->mensaje		= "Error, no se realizó la conexión a la base de datos";
			}else{
				$this->mensaje		= "Error, la consulta no puede estar vacía";
			}
		}
	}
	//-----------------------------------------------------------------------	

	function cerrarConexion( ) {
		if( $this->conexion ) {
			//pg_close( $this->conexion ) ;
			$this->conexion = null;
		}
	}
}