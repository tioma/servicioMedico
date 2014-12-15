<?php

include_once 'bd.php';
include_once 'Tratamiento.php';

abstract class busquedas {
	var $bd;
	var $query;
	var $datos;
	
	function busquedas(){
		$this->bd = new bd();
	}

	function traerResultados(){

		$this->bd->conectar();
		$this->bd->consultar($this->query);
		$this->bd->cerrarConexion();

		return $this->bd->datos;
	}
}

class buscarUsuarios extends busquedas{
	function buscarUsuarios(){
		$this->query = "SELECT * from habagp.permisosmed order by usuario";

		parent::busquedas();
	}
}

class licenciasEnTratamiento extends busquedas{
	var $miTratamiento;
	
	function licenciasEnTratamiento($unTratamiento){
		$this->query = "select * from habagp.tipolic WHERE codlic = '" . $unTratamiento->tipoLicencia->codigo . "'";
		$this->miTratamiento = $unTratamiento;
		
		parent::busquedas();
	}
	
	function traerResultados(){
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla($this->bd->datos);
		}
		else {
			return "";
		}
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	protected function armarTabla($datos){
		$resultado = '';
		
		$resultado = '<select name="tipo_licencia" id="tipo_licencia" ';
		if (!$this->miTratamiento->tipoLicencia->puedeCambiar() || trim($this->miTratamiento->estado) == 'De Alta'){
			$resultado .= 'disabled="disabled" ';	
		}
		$resultado .= '>';
		
		while ($tipolic = pg_fetch_assoc($datos)){
			$resultado .= '<option value="' . $tipolic['codlic'] . '" ';
			if ($this->miTratamiento->tipoLicencia->codigo == $tipolic['codlic']){ 
				$resultado .= "selected"; 
			}
			$resultado .= ' >' . $tipolic['codlic'] . ' - ' . $tipolic['descripcion'] . '</option>';
		}
		
		if ($this->miTratamiento->tipoLicencia->puedeCambiar() && trim($this->miTratamiento->estado) != 'De Alta'){
			$resultado .= '<option value="LT">LT - 15 dias o mas</option>';
		}
		$resultado .= '</select>';
		return $resultado;
	}
	
}

class tiposDeLicencias extends busquedas{
	
	function tiposDeLicencias(){
		$this->query = "select * from habagp.tipolic";
		
		parent::busquedas();
	}
}

class tratamientosVencen extends busquedas{
	var $resto = 3;
	
	function tratamientosVencen(){
		$this->query = "select  idtrat, 
								nro_legajo, 
								nombre, 
								enfermedad, 
								tipolic, 
								est.descripcion as estadolic, 
								extract(day from fechaalta - now()) as resto 
						from habagp.fichatratamientos as fi
							inner join habagp.maestro as mae on nro_legajo = legajo
							inner join habagp.enfermedades as enf on codenfermedad = codigo
							inner join habagp.tipoestadolic as est on estadolic = codtipoestadolic";
		
		parent::busquedas();
	}
	
	function setResto($unresto){
		$this->resto = $unresto;
	}
	
	function traerResultados(){
		$this->query .= " where estadolic = 'C' and extract(day from fechaalta - now()) < " . $this->resto . "
						order by resto";
		
		return parent::traerResultados();
	}
}

class buscarTratamiento extends busquedas{
	function buscarTratamiento(){
		$this->query = "select idtrat, nro_legajo, nombre, codenfermedad, enfermedad, fechaini::date, fechaalta::date, tipolic, estadolic, est.descripcion as descestadolic, diasactual, fi.descripcion as desctrat
						from habagp.fichatratamientos as fi
							inner join habagp.maestro as mae on nro_legajo = legajo
							inner join habagp.enfermedades as enf on codenfermedad = codigo
							inner join habagp.tipoestadolic as est on estadolic = codtipoestadolic";
		
		parent::busquedas();
	}

	function ponerFiltros($filtros, $pagina){

		$whereClause = '';
		$orderClause = '';

		if (isset($filtros['nombre']) && $filtros['nombre'] != ''){
			$whereClause = " nombre LIKE '%" . strtoupper($filtros['nombre']) . "%' ";
		}
		if (isset($filtros['legajo']) && $filtros['legajo'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " nro_legajo LIKE '%" . $filtros['legajo'] . "%' ";
		}
		if (isset($filtros['enfermedad']) && $filtros['enfermedad'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " enfermedad LIKE '%" . strtoupper($filtros['enfermedad']) . "%' ";
		}
		if (isset($filtros['inicio']) && $filtros['inicio'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaini < '" . strtoupper($filtros['inicio']) . "' ";
		}
		if (isset($filtros['fechaalta']) && $filtros['fechaalta'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaalta < '" . strtoupper($filtros['fechaalta']) . "' ";
		}
		if (isset($filtros['estado']) && $filtros['estado'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " est.descripcion = '" . $filtros['estado'] . "' ";
		}
		if (isset($filtros['tipoLicencia']) && $filtros['tipoLicencia'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " tipolic = '" . $filtros['tipoLicencia'] . "' ";
		}
		if (isset($filtros['orden']) && $filtros['orden'] != ''){
			$orderClause = " ORDER BY " . $filtros['orden'] . " " . $filtros['tipoOrden'];
		}
		if ($whereClause != ''){
			$whereClause = " WHERE" . $whereClause;
		}
		$this->query .= $whereClause . $orderClause . " LIMIT " . $pagina['limite'] . " OFFSET " . $pagina['offset'];
	}

	function cantidadRegistros($filtros){
		$queryContar = 'SELECT count(idtrat) as total
						from habagp.fichatratamientos as fi
							inner join habagp.maestro as mae on nro_legajo = legajo
							inner join habagp.enfermedades as enf on codenfermedad = codigo
							inner join habagp.tipoestadolic as est on estadolic = codtipoestadolic';

		$whereClause = '';

		if (isset($filtros['nombre']) && $filtros['nombre'] != ''){
			$whereClause = " nombre LIKE '%" . strtoupper($filtros['nombre']) . "%' ";
		}
		if (isset($filtros['legajo']) && $filtros['legajo'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " nro_legajo LIKE '%" . $filtros['legajo'] . "%' ";
		}
		if (isset($filtros['enfermedad']) && $filtros['enfermedad'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " enfermedad LIKE '%" . strtoupper($filtros['enfermedad']) . "%' ";
		}
		if (isset($filtros['inicio']) && $filtros['inicio'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaini < '" . strtoupper($filtros['inicio']) . "' ";
		}
		if (isset($filtros['fechaalta']) && $filtros['fechaalta'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaalta < '" . strtoupper($filtros['fechaalta']) . "' ";
		}
		if (isset($filtros['estado']) && $filtros['estado'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " est.descripcion = '" . $filtros['estado'] . "' ";
		}
		if (isset($filtros['tipoLicencia']) && $filtros['tipoLicencia'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " tipolic = '" . $filtros['tipoLicencia'] . "' ";
		}
		if ($whereClause != ''){
			$whereClause = " WHERE" . $whereClause;
		}

		$queryContar .= $whereClause;

		$this->bd->conectar();
		$this->bd->consultar($queryContar);
		$this->bd->cerrarConexion();

		return $this->bd->datos[0]['total'];
	}
	
	function porID($idTrat){
		$this->query .= " WHERE idtrat = " . $idTrat;
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		$this->bd->cerrarConexion();

		return $this->bd->datos[0];
		
	}

	
	function generoExcel(){
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTablaExcel($this->bd->datos);
		}
		else {
			return "No se han encontrado resultado";
		}
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	function generoListado(){
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarListado($this->bd->datos);
		}
		else {
			return "No se han encontrado resultado";
		}
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	function armarTablaExcel($datos){
		$resultado = '<table id="tratamientos" cellspacing="0" border="1" style="width:100%">
			<tr>
				<td align="center" colspan="8"
			<tr class="cabeceraTabla" align="center">
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Enfermedad</td>
				<td>Inicio</td>
				<td>Alta</td>
				<td>D&iacute;as acumulados</td>
				<td>Licencia</td>
				<td>Estado</td>
			</tr>';
		
		while ($tratamiento = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $tratamiento['nro_legajo'] . "</td>";
			$resultado .= "<td>" . $tratamiento['nombre'] . "</td>";
			$resultado .= "<td>" . $tratamiento['enfermedad'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaini'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaalta'] . "</td>";
			$resultado .= "<td>" . $tratamiento['diasactual'] . "</td>";
			$resultado .= "<td>" . $tratamiento['tipolic'] . "</td>";
			$resultado .= "<td>" . $tratamiento['estadolic'] . "</td>";
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}
	
	protected function armarListado($datos){
		$resultado = '<table id="tratamientos" cellspacing="0" border="1" style="width:100%">
			<tr class="cabeceraTabla" align="center">
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Enfermedad</td>
				<td>Inicio</td>
				<td>Alta</td>
				<td>D&iacute;as acum.</td>
				<td>Licencia</td>
				<td>Estado</td>
				<td>Ver</td>
			</tr>';
		
		while ($tratamiento = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $tratamiento['nro_legajo'] . "</td>";
			$resultado .= "<td>" . $tratamiento['nombre'] . "</td>";
			$resultado .= "<td>" . $tratamiento['enfermedad'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaini'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaalta'] . "</td>";
			$resultado .= "<td align='center'>" . $tratamiento['diasactual'] . "</td>";
			$resultado .= "<td align='center'>" . $tratamiento['tipolic'] . "</td>";
			$resultado .= "<td>" . $tratamiento['estadolic'] . "</td>";
			$resultado .= '<td><a href="fichaTratamiento.php?id=' . $tratamiento['idtrat'] . '"><img src="img/edit.gif"/></a></td>';
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}

}

class buscarEvolucion extends busquedas {
	function buscarEvolucion(){
		$this->query = "SELECT 
							id,
							legajo,
							evol.idtrat,
							ant.enfermedad as antenf,
							act.enfermedad as nuevaenf,
							fini::date,
							ffinal::date,
							descrip,
							dias
						FROM habagp.tblevoltrat evol
							inner join habagp.fichatratamientos as fi on evol.idtrat = fi.idtrat
							left join habagp.enfermedades as ant on enfant = ant.codigo
							inner join habagp.enfermedades as act on enfactual = act.codigo";
		
		parent::busquedas();
	}
	
	function evolucionTratamiento($idtrat){
		$this->query.=" WHERE evol.idtrat = " . $idtrat . " ORDER BY ffinal ASC, id";
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		$this->bd->cerrarConexion();
		
		return $this->bd->datos;
	}

}

class buscarEnfermedad extends busquedas {
	function buscarEnfermedad(){
		$this->query = "SELECT 
							codigo,
							enfermedad
						FROM habagp.enfermedades ORDER BY codigo";
		parent::busquedas();
	}

	function traerResultados2(){
		$resultado = "No se han encontrado registros";
		
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla2($this->bd->datos);
		}
		
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	function traerResultados3(){
		$resultado = "No se han encontrado registros";
		
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla3($this->bd->datos);
		}
		
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	function filtrar($unParam){
		$this->query.=" WHERE codigo like '%" . $unParam . "%' OR enfermedad like '%" . $unParam . "%' ORDER BY codigo ASC LIMIT 20";
	}

	protected function armarTabla($datos){
		$resultado = '<table id="enfermedades" cellspacing="0" border="1" style="width:100%">
			<tr class="cabeceraTabla" align="center">
				<td align="center">C&oacute;digo</td>
				<td colspan="2" align="center">Enfermedad</td>
				<td align="center">Sel.</td>
			</tr>';
		
		while ($enfermedad = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;" >';
			$resultado .= '<td align="center">' . $enfermedad['codigo'] . '</td>';
			$resultado .= '<td colspan="2" align="center" class="seleccionEnfermedad">' . $enfermedad['enfermedad'] . '</td>';
			$resultado .= '<td align="center"><a href="#"><img src="img/edit.gif" class="seleccionEnfermedad" onclick="seleccionarEnfermedad(\''. $enfermedad['codigo'] . '\', \'' . $enfermedad['enfermedad'] . '\')" /></a></td>';
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}

	protected function armarTabla2($datos){
		$resultado = '<table id="enfermedades" cellspacing="0" border="1" style="width:100%">
			<tr class="cabeceraTabla" align="center">
				<td align="center">C&oacute;digo</td>
				<td colspan="2" align="center">Enfermedad</td>
				<td align="center">Sel.</td>
			</tr>';
		
		while ($enfermedad = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;" >';
			$resultado .= '<td align="center">' . $enfermedad['codigo'] . '</td>';
			$resultado .= '<td colspan="2" align="center" class="seleccionEnfermedad">' . $enfermedad['enfermedad'] . '</td>';
			$resultado .= '<td align="center"><a href="#"><img src="img/edit.gif" class="seleccionEnfermedad" onclick="seleccionarEnfermedad2(\''. $enfermedad['codigo'] . '\', \'' . $enfermedad['enfermedad'] . '\')" /></a></td>';
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}
	
	protected function armarTabla3($datos){
		$resultado = '<table id="enfermedades" cellspacing="0" border="1" style="width:100%">
			<tr class="cabeceraTabla" align="center">
				<td align="center">C&oacute;digo</td>
				<td colspan="2" align="center">Enfermedad</td>
				<td align="center">Sel.</td>
			</tr>';
		
		while ($enfermedad = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;" class="seleccionEnfermedad" id="campo-enfermedad---'. $enfermedad['codigo'] . ' - ' . $enfermedad['enfermedad'] . '">';
			$resultado .= '<td align="center">' . $enfermedad['codigo'] . '</td>';
			$resultado .= '<td colspan="2" align="center">' . $enfermedad['enfermedad'] . '</td>';
			$resultado .= '<td align="center"><a href="#"><img src="../../img/edit.gif" /></a></td>';
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}
}

class buscarPersona extends busquedas {

	function buscarPersona(){
		$this->query = "SELECT
							mae.legajo as legajo,
							nombre,
							diasacum,
							diasrestantes,
							ultausencia::date
						FROM habagp.maestro mae
							inner join habagp.tratcabecera trat on mae.legajo = trat.legajo";

		parent::busquedas();
	}

}

class buscarLicenciasAcumuladas extends busquedas {
	function buscarLicenciasAcumuladas(){
		$this->query = "SELECT
							a.legajo,
							b.nombre,
							a.diasacum,
							a.diasrestantes,
							a.ultausencia::date
						FROM habagp.tratcabecera a
							inner join habagp.maestro b on a.legajo = b.legajo ";

		parent::busquedas();
	}

	function traerResultados(){
		$resultado = "No se han encontrado registros";

		$this->bd->conectar();

		$this->bd->consultar($this->query);

		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla($this->bd->datos);
		}

		$this->bd->cerrarConexion();

		return $resultado;
	}
	
	function porDiasRestantes($dias){
		if ($dias == ""){
			$dias = 0;
		}
		$this->query .= "WHERE diasrestantes <= " . $dias . " AND est_servic = 1";
	}

	function porLegajo($legajo){
		
		if (is_numeric(strtoupper($legajo)))
			$this->query.="WHERE a.legajo like '" . $legajo . "%' ";
		else 
			$this->query.="WHERE nombre like '%" . strtoupper($legajo) . "%' ";
			
		$this->query .= "AND est_servic=1 limit 20";
	}
	
	protected function armarTabla($datos){
		$resultado = '<table id="licenciasAcumuladas" cellspacing="0" border="1">
			<tr class="cabeceraTabla" align="center">
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Acumulados</td>
				<td>Restantes</td>
				<td>Ultima Ausencia</td>
			</tr>';

		while ($persona = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $persona['legajo'] . "</td>";
			$resultado .= "<td>" . $persona['nombre'] . "</td>";
			$resultado .= "<td>" . $persona['diasacum'] . "</td>";
			$resultado .= "<td>" . $persona['diasrestantes'] . "</td>";
			$resultado .= "<td>" . $persona['ultausencia'] . "</td>";
			$resultado .= "</tr>";
		}

		return $resultado .= '</table>';
	}

}

class generaListados extends busquedas{
	function generaListados(){
		$this->query = "select idtrat, nro_legajo, nombre, codenfermedad, enfermedad, fechaini::date, fechaalta::date, tipolic, est.descripcion as estadolic, diasactual, diasacum, diasrestantes, fi.descripcion as desctrat
						from habagp.fichatratamientos as fi
							inner join habagp.maestro as mae on nro_legajo = mae.legajo
							inner join habagp.enfermedades as enf on codenfermedad = codigo
							inner join habagp.tipoestadolic as est on estadolic = codtipoestadolic
							inner join habagp.tratcabecera as cab on nro_legajo = cab.legajo";
		
		parent::busquedas();
	}

	function ponerFiltros($filtros){

		$whereClause = '';

		if (isset($filtros['nombre']) && $filtros['nombre'] != ''){
			$whereClause = " nombre LIKE '%" . strtoupper($filtros['nombre']) . "%' ";
		}
		if (isset($filtros['legajo']) && $filtros['legajo'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " nro_legajo LIKE '%" . $filtros['legajo'] . "%' ";
		}
		if (isset($filtros['enfermedad']) && $filtros['enfermedad'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " enfermedad LIKE '%" . strtoupper($filtros['enfermedad']) . "%' ";
		}
		if (isset($filtros['inicio']) && $filtros['inicio'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaini < '" . strtoupper($filtros['inicio']) . "' ";
		}
		if (isset($filtros['fechaalta']) && $filtros['fechaalta'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " fechaalta < '" . strtoupper($filtros['fechaalta']) . "' ";
		}
		if (isset($filtros['estado']) && $filtros['estado'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " est.descripcion = '" . $filtros['estado'] . "' ";
		}
		if (isset($filtros['tipoLicencia']) && $filtros['tipoLicencia'] != ''){
			if ($whereClause != ''){
				$whereClause .= "AND";
			}
			$whereClause .= " tipolic = '" . $filtros['tipoLicencia'] . "' ";
		}
		if ($whereClause != ''){
			$whereClause = " WHERE" . $whereClause;
		}
		$this->query .= $whereClause;
	}

	function porNombre($nombre){
		$resultado = "No se han encontrado registros";
		$this->bd->conectar();
		
		$this->query .= " WHERE (nombre LIKE '%" . strtoupper($nombre) . "%' OR nro_legajo LIKE '%" . $nombre . "%')";
		
	}
	
	function porEnfermedad($enfermedad){
		$resultado = "No se han encontrado registros";
		$this->bd->conectar();
		
		$this->query .= " WHERE enfermedad LIKE '%" . strtoupper($enfermedad) . "%'";
	}
	
	function porInicio($inicio){
		$resultado = "No se han encontrado registros";
		$this->bd->conectar();
		
		$this->query .= " WHERE fechaini < '" . strtoupper($inicio) . "'";
	}
	
	function porAlta($alta){
		$resultado = "No se han encontrado registros";
		$this->bd->conectar();
		
		$this->query .= " WHERE fechaalta < '" . strtoupper($alta) . "'";
	}
	
	function sinFiltros(){
		$resultado = "No se han encontrado registros";
	}
	
	function porID($idTrat){
		$this->query .= " WHERE idtrat = " . $idTrat;
		
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		$this->bd->cerrarConexion();

		return pg_fetch_assoc($this->bd->datos);
		
	}
	
	function soloAltas(){
		$this->query .= " AND est.descripcion = 'De Alta'";
	}
	
	function soloEnCurso(){
		$this->query .= " AND est.descripcion = 'Con licencia'";
	}
	
	function tipoLicencia($unTipo){
		$this->query .= " AND tipolic = '" . $unTipo . "'";
	}
	
	function conOrdenYLimite($orden, $limite){
		$this->query .= " ORDER BY " . $orden . " DESC LIMIT " . $limite;
	}
	
	function conOrden($orden){
		$this->query .= " ORDER BY " . $orden;
	}
	
	function generoExcel(){
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTablaExcel($this->bd->datos);
		}
		else {
			return "No se han encontrado resultado";
		}
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	function generoListado(){
		$this->bd->conectar();
		
		$this->bd->consultar($this->query);
		
		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla($this->bd->datos);
		}
		else {
			return "No se han encontrado resultado";
		}
		$this->bd->cerrarConexion();
		
		return $resultado;
	}
	
	function armarTablaExcel($datos){
		$resultado = '<table id="tratamientos" cellspacing="0" border="1" style="width:100%">
			<tr>
				<td align="center" colspan="8">Fecha del listado:'
					. date("d-m-Y") .
				'</td>
			</tr> 
			<tr class="cabeceraTabla" align="center">
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Enfermedad</td>
				<td>Inicio</td>
				<td>Alta</td>
				<td>D&iacute;as actual</td>
				<td>D&iacute;as acum.</td>
				<td>D&iacute;as restantes</td>
				<td>Licencia</td>
				<td>Estado</td>
			</tr>';
		
		while ($tratamiento = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $tratamiento['nro_legajo'] . "</td>";
			$resultado .= "<td>" . $tratamiento['nombre'] . "</td>";
			$resultado .= "<td>" . $tratamiento['enfermedad'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaini'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaalta'] . "</td>";
			$resultado .= "<td>" . $tratamiento['diasactual'] . "</td>";
			$resultado .= "<td>" . $tratamiento['diasacum'] . "</td>";
			$resultado .= "<td>" . $tratamiento['diasrestantes'] . "</td>";
			$resultado .= "<td>" . $tratamiento['tipolic'] . "</td>";
			$resultado .= "<td>" . $tratamiento['estadolic'] . "</td>";
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}
	
	protected function armarTabla($datos){
		$resultado = '<table id="tratamientos" cellspacing="0" border="1" style="width:100%">
			<tr class="cabeceraTabla" align="center">
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Enfermedad</td>
				<td>Inicio</td>
				<td>Alta</td>
				<td>D&iacute;as actual</td>
				<td>Licencia</td>
				<td>Estado</td>
				<td>Ver</td>
			</tr>';
		
		while ($tratamiento = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $tratamiento['nro_legajo'] . "</td>";
			$resultado .= "<td>" . $tratamiento['nombre'] . "</td>";
			$resultado .= "<td>" . $tratamiento['enfermedad'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaini'] . "</td>";
			$resultado .= "<td>" . $tratamiento['fechaalta'] . "</td>";
			$resultado .= "<td align='center'>" . $tratamiento['diasactual'] . "</td>";
			$resultado .= "<td align='center'>" . $tratamiento['tipolic'] . "</td>";
			$resultado .= "<td>" . $tratamiento['estadolic'] . "</td>";
			$resultado .= '<td><a href="fichaTratamiento.php?id=' . $tratamiento['idtrat'] . '"><img src="img/edit.gif"/></a></td>';
			$resultado .= "</tr>"; 
		}
		
		return $resultado .= '</table>';
	}
	
}

class buscarOtrasLicencias extends busquedas {
	function buscarOtrasLicencias(){
		$this->query = "SELECT
							a.idotraslic,
							a.legajo,
							b.nombre,
							c.descripcion,
							a.anio,
							a.dias
						FROM habagp.otraslicencias a
							inner join habagp.maestro b on b.legajo = a.legajo
							inner join habagp.tipolic c on a.tipolic = c.codlic ";

		parent::busquedas();
	}

	function traerResultados(){
		$resultado = "No se han encontrado registros";

		$this->bd->conectar();

		$this->bd->consultar($this->query);

		if ($this->bd->cantidad > 0){
			$resultado = $this->armarTabla($this->bd->datos);
		}

		$this->bd->cerrarConexion();

		return $resultado;
	}

	function porLegajo($legajo){
		
		if (is_numeric(strtoupper($legajo)))
			$this->query.="WHERE a.legajo like '" . $legajo . "%' ";
		else 
			$this->query.="WHERE nombre like '%" . strtoupper($legajo) . "%' ";
			
		$this->query .= "AND est_servic = 1";
	}

	protected function armarTabla($datos){
		$resultado = '<table id="licenciasAcumuladas" cellspacing="0" border="1">
			<tr class="cabeceraTabla" align="center">
				<td>NroLic</td>
				<td>Legajo</td>
				<td>Nombre</td>
				<td>Descripcion</td>
				<td>Anio</td>
				<td>Acumulados</td>
			</tr>';

		while ($persona = pg_fetch_assoc($datos)){
			$resultado .= '<tr style="font-size: 13px;">';
			$resultado .= "<td>" . $persona['idotraslic'] . "</td>";
			$resultado .= "<td>" . $persona['legajo'] . "</td>";
			$resultado .= "<td>" . $persona['nombre'] . "</td>";
			$resultado .= "<td>" . $persona['descripcion'] . "</td>";
			$resultado .= "<td>" . $persona['anio'] . "</td>";
			$resultado .= "<td>" . $persona['dias'] . "</td>";
			$resultado .= "</tr>";
		}

		return $resultado .= '</table>';
	}

}
?>