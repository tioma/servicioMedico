<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 03/12/14
 * Time: 09:07
 */

include_once 'bd.php';

class Usuario {

	var $nombre;
	var $tratamientos;
	var $listados;
	var $parametros;

	var $bd;

	function Usuario(){
		$this->bd = new bd();
	}

	function setNombre($unNombre){
		$this->nombre = $unNombre;
	}

	function setTratamientos($valor){
		if ($valor == 1){
			$valor = 'true';
		} else {
			$valor = 'false';
		}
		$this->tratamientos = $valor;
	}

	function setListados($valor){
		if ($valor == 1){
			$valor = 'true';
		} else {
			$valor = 'false';
		}
		$this->listados = $valor;
	}

	function setParametros($valor){
		if ($valor == 1){
			$valor = 'true';
		} else {
			$valor = 'false';
		}
		$this->parametros = $valor;
	}

	function guardarCambios(){
		$query = "UPDATE habagp.permisosmed SET tratamientos = " . $this->tratamientos . ", listados = " . $this->listados . ", parametros = " . $this->parametros . " WHERE usuario = '" . $this->nombre . "'";

		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();

		return $this->bd->estado;
	}

	function nuevoUsuario(){
		$query = "INSERT INTO habagp.permisosmed VALUES ('" . $this->nombre . "', " . $this->parametros . ", " . $this->tratamientos . ", " . $this->listados . ")";

		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();

		return $this->bd->estado;
	}

	function eliminar(){
		$query = "DELETE from habagp.permisosmed WHERE usuario = '" . $this->nombre . "'";

		$this->bd->conectar();
		$this->bd->consultar($query);
		$this->bd->cerrarConexion();

		return $this->bd->estado;
	}

}