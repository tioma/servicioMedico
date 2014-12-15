<?php

include_once 'bd.php';

class Estadistica{
	var $titulo;
	var $datos = "";
	var $referencia;
	var $constante = 5;
	var $rutaGrafico;
	var $query;
	var $inicio;
	var $final;
	var $limite;
	var $bd;
	
	function Estadistica(){
		$this->inicio = "1910-01-01";
		$this->final = date("Y-m-d");
		$this->bd = new bd();
	}
	
	function setInicio($unaFecha){
		$this->inicio = $unaFecha;
	}
	
	function setFinal($unaFecha){
		$this->final = $unaFecha;
	}

	function setLimite($unLimite){
		$this->limite = $unLimite;
	}
	
}

class promedioDiasLicencia extends Estadistica{
	var $rutaAnexo = '<img src="graficos/graphpastel.php?';
	var $rutaDiasReal = '<img src="graficos/graphbarras.php?';
	var $datosAnexo;
	var $datosDiasReal;
	var $queryTotal;
	
	function promedioDiasLicencia(){
		$this->titulo = "";
		$this->rutaGrafico = '<img src="graficos/graphbarras.php?';
		$this->query = "select count(idtrat) as cant, round(avg(diasactual)) as prom, sum(diasactual) as total, count(distinct(nro_legajo)) as agentes, tipolic from habagp.fichatratamientos";
		
		$this->queryTotal = "select count(idtrat) as cant from habagp.fichatratamientos";
		
		parent::Estadistica();
	}
	
	function generar(){
		$this->bd->conectar();
		
		$this->queryTotal .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->bd->consultar($this->queryTotal);
		$resultado = pg_fetch_assoc($this->bd->datos);
		$total = $resultado['cant'];
		
		$totalAgentes = 0;
		$totalDias = 0;
		$totalLicencias = 0;
		
		$this->query .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->query .= " group by tipolic";
		
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$this->datos = 'dat=' . $resultado['prom'];
			
			$porcentaje = round($resultado['cant']*100/$total);
			$this->datosAnexo = 'dat=' . $resultado['cant'];
			$this->datosDiasReal = 'dat=' . $resultado['total'];
			
			$this->referencia = '<table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">Tipo de licencia</td><td align="center">Promedio de d&iacute;as</td><td align="center">Total d&iacute;as</td><td align="center">Total agentes</td><td align="center">Licencias</td><td align="center">Porcentaje</td></tr>';
			$this->referencia .= '<tr><td align="center"><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td align="center"><div>' . $resultado['tipolic'] . '</div></td><td align="center"><div>' . $resultado['prom'] . ' d&iacute;as</div></td><td align="center"><div>' . $resultado['total'] . ' d&iacute;as</div></td><td align="center"><div>' . $resultado['agentes'] . ' agentes</div></td><td align="center">' . $resultado['cant'] . ' licencias </td><td align="center">' . $porcentaje . '%</td></tr>';
			
			$totalAgentes += $resultado['agentes'];
			$totalDias += $resultado['total'];
			$totalLicencias += $resultado['cant']; 
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$this->datos .= ',' . $resultado['prom'];
				
				$porcentaje = round($resultado['cant']*100/$total);
				$this->datosAnexo .= ',' . $resultado['cant'];
				$this->datosDiasReal .= ',' . $resultado['total'];
				
				$this->referencia .= '<tr><td align="center"><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td align="center"><div>' . $resultado['tipolic'] . '</div></td><td align="center"><div>' . $resultado['prom'] . ' d&iacute;as</div></td><td align="center"><div>' . $resultado['total'] . ' d&iacute;as</div></td><td align="center"><div>' . $resultado['agentes'] . ' agentes</div></td><td align="center">' . $resultado['cant'] . ' licencias </td><td align="center">' . $porcentaje . '%</td></tr>';
				
				$totalAgentes += $resultado['agentes'];
				$totalDias += $resultado['total'];
				$totalLicencias += $resultado['cant'];
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaDiasReal .= $this->datosDiasReal . '&bkg=FFFFFF&ttl=' . $this->titulo . '" ></td><td><div class="tituloGrafico">Promedio de d&iacute;as por tipo de licencia</div>';
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&ttl=' . $this->titulo . '" ></td><td><div class="tituloGrafico">Licencias totales</div><br>';
		$this->rutaGrafico .= $this->rutaAnexo . $this->datosAnexo . '&bkg=FFFFFF&wdt=200&hgt=100" ></td></tr><tr align="center"><td colspan="3">';
		$this->rutaGrafico .= $this->referencia . '</table></td>';
		$this->rutaGrafico .= '</td></tr><tr align="center"><td colspan="3"><div class="fuenteTotales">Total de d&iacute;as otorgados= ' . $totalDias . '</div></td></tr>';
		$this->rutaGrafico .= '<tr align="center"><td colspan="3"><div class="fuenteTotales">Total de agentes atendidos= ' . $totalAgentes . '</div></td></tr>';
		$this->rutaGrafico .= '<tr align="center"><td colspan="3"><div class="fuenteTotales">Total de licencias otorgadas= ' . $totalLicencias .'</div>';
		
		return '<div class="tituloGrafico">Total de d&iacute;as por tipo de licencia</div>' . $this->rutaDiasReal . $this->rutaGrafico;
	}
}

class topEnfermedades extends Estadistica{
	var $tipolic;
	var $licenciaTitulo;
	
	function topEnfermedades(){
		$this->titulo = "Enfemedades+frecuentes";
		$this->rutaGrafico = '<img src="graficos/graphbarras.php?';
		$this->query = "select 
							count(codenfermedad) as cant, 
							enfermedad 
						from habagp.fichatratamientos 
							inner join habagp.enfermedades on codenfermedad = codigo";
		
		parent::Estadistica();
	}
	
	function setTipolic($unaLic){
		$this->tipolic = $unaLic;
		switch ($unaLic){
			case "CT":
				$this->licenciaTitulo = "licencia de Corto Tratamiento";
				break;
			case "LT":
				$this->licenciaTitulo = "licencia de Largo Tratamiento";
				break;
			case "MA":
				$this->licenciaTitulo = "licencia por Maternidad";
				break;
			case "A17G":
				$this->licenciaTitulo = "art&iacute;culo 17 con goce de sueldo";
				break;
			case "A17S":
				$this->licenciaTitulo = "art&iacute;culo 17 sin goce de sueldo";
				break;
			case "ART9":
				$this->licenciaTitulo = "licencia por Paternidad";
				break;
			case "ACC":
				$this->licenciaTitulo = "licencia por Accidente";
				break;
		}
	}
	
	function generar(){
		$this->query .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->query .= " AND tipolic = '" . $this->tipolic . "'";
		$this->query .= " group by enfermedad  
						  order by cant desc 
						  limit " . $this->limite;
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$this->datos = 'dat=' . $resultado['cant'];
			
			$this->referencia = '<table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">Enfermedad</td><td align="center">Cantidad</td></tr>';
			$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td>' . $resultado['enfermedad'] . '</td><td>' . $resultado['cant'] . '</td></tr>';
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$this->datos .= ',' . $resultado['cant'];
				$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td>' . $resultado['enfermedad'] . '</td><td>' . $resultado['cant'] . '</td></tr>';
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&ttl=" ><br>';
		$this->rutaGrafico .= $this->referencia . '</table>';
		
		return '<div class="tituloGrafico">Enfermedades frecuentes para ' . $this->licenciaTitulo . '</div>' . $this->rutaGrafico;
	}
}

class licenciasPorEmpleado extends Estadistica{
	var $legajo;
	var $queryTotal;
	
	function licenciasPorEmpleado(){
		$this->titulo = "Licencias+por+empleado";
		$this->rutaGrafico = '<img src="graficos/graphpastel.php?';
		$this->query = "select count(idtrat) as cant, tipolic 
						from habagp.fichatratamientos";
		
		$this->queryTotal = "select count(idtrat) as cant from habagp.fichatratamientos";
		parent::Estadistica();
	}
	
	function setLegajo($unLegajo){
		$this->legajo = $unLegajo;
	}
	
	function generar(){
		$this->bd->conectar();
		
		$this->queryTotal .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->queryTotal .= " AND nro_legajo = '" . $this->legajo . "'";
		
		$this->bd->consultar($this->queryTotal);
		$resultado = pg_fetch_assoc($this->bd->datos);
		$total = $resultado['cant'];
		
		$this->query .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->query .= " AND nro_legajo = '" . $this->legajo . "'";
		$this->query .= " group by tipolic";
		
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$porcentaje = round($resultado['cant']*100/$total);
			$this->datos = 'dat=' . $resultado['cant'];
			
			$this->referencia = '<table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">Tipo de licencia</td><td align="center">Cantidad</td><td>Porcentaje</td></tr>';
			$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td>' . $resultado['tipolic'] . '</td><td>' . $resultado['cant'] . '</td><td>' . $porcentaje . '%</td></tr>';
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$porcentaje = round($resultado['cant']*100/$total);
				$this->datos .= ',' . $resultado['cant'];
				$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=2&dim=5&bkg=FFFFFF"></td><td>' . $resultado['tipolic'] . '</td><td>' . $resultado['cant'] . '</td><td>' . $porcentaje . '%</td></tr>';
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&wdt=200&hgt=100" ><br>';
		$this->rutaGrafico .= $this->referencia . '</table>';
		
		return $this->rutaGrafico;
	}
}

class rankingEmpleados extends Estadistica {
	var $orden = 'cant';
	var $anexo = 'dias';
	var $rutaAnexo = '<td><img src="../../graficos/graphbarras.php?';
	var $datosAnexo;
	var $tituloAnexo = "Anexo";
	
	function rankingEmpleados(){
		
		$this->rutaGrafico = '<td><img src="../../graficos/graphbarras.php?';
		$this->query = "select count(idtrat) as cant, sum(diasactual) as dias, nro_legajo, nombre
						from habagp.fichatratamientos 
							inner join habagp.maestro on nro_legajo = legajo";
						
	
		parent::Estadistica();
	}
	
	function setOrden($unOrden){
		switch ($unOrden){
			case "cant":
				$this->orden = "cant";
				$this->anexo = "dias";
				break;
			case "dias":
				$this->orden = "dias";
				$this->anexo = "cant";
				break;
		}
	}
	
	function generar(){
		switch ($this->orden){
			case "cant":
				$this->titulo = "Ranking+empleados+-+Licencias";
				$this->tituloAnexo = "Anexo+-+Dias+pedidos";
				break;
			case "dias":
				$this->titulo = "Ranking+empleados+-+Dias+pedidos";
				$this->tituloAnexo = "Anexo+-+Licencias";
				break;
		}
		
		$this->query .= " WHERE fechaini between '" . $this->inicio . "' and '" . $this->final . "'";
		$this->query .= " group by nro_legajo, nombre 
						  order by " . $this->orden . " desc 
						  limit " . $this->limite;
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$this->datos = 'dat=' . $resultado[$this->orden];
			$this->datosAnexo = 'dat=' . $resultado[$this->anexo];
			
			$this->referencia = '<td colspan="2"><table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">Empleado</td><td align="center">Cantidad</td><td>D&iacute;as</td></tr>';
			$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['nro_legajo'] . '- ' . $resultado['nombre'] . '</td><td>' . $resultado['cant'] . ' licencias</td><td>' . $resultado['dias'] . ' d&iacute;as</td></tr>';
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$this->datos .= ',' . $resultado[$this->orden];
				$this->datosAnexo .= ',' . $resultado[$this->anexo];
				$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['nro_legajo'] . '- ' . $resultado['nombre'] . '</td><td>' . $resultado['cant'] . ' licencias</td><td>' . $resultado['dias'] . ' d&iacute;as</td></tr>';
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&ttl=' . $this->titulo . '" ><br></td>';
		$this->rutaAnexo .= $this->datosAnexo . '&bkg=FFFFFF&ttl=' . $this->tituloAnexo . '" ><br></td>';
		$this->rutaGrafico .= $this->rutaAnexo;
		$this->rutaGrafico .='<tr align="center">' . $this->referencia . '</table></td></tr>';
		
		return $this->rutaGrafico;
	}
	
	function obtenerResultados(){
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		$this->bd->cerrarConexion();
		
		if ($this->bd->estado){
			return $this->bd->datos;
		} else {
			return "";
		}
	}
}

class licenciasPorAño extends Estadistica{
	var $subQuery = 'SELECT count(idtrat) as cant, 
							extract(year from fechaini) as ano
					 from habagp.fichatratamientos
					 group by ano
					 order by ano';
	
	function licenciasPorAño(){
		$this->titulo = 'Licencias por a�o';
		$this->rutaGrafico = '<tr align="center"><td><div class="tituloGrafico">Licencias por a&ntilde;o</div><img src="../../graficos/graphbarras.php?';
		$this->query = 'SELECT cant, ano from (' . $this->subQuery . ') as foo';
	
		parent::Estadistica();
	}
	
	function generar(){
		$this->query .= " WHERE ano between " . $this->inicio . " AND " . $this->final;
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$this->datos = 'dat=' . $resultado['cant'];
			
			$this->referencia = '<table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">A&ntilde;o</td><td align="center">Cantidad de licencias</td></tr>';
			$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['ano'] . '</td><td>' . $resultado['cant'] . ' licencias</td></tr>';
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$this->datos .= ',' . $resultado['cant'];
				$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['ano'] . '</td><td>' . $resultado['cant'] . ' licencias</td></tr>';
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&ttl="" ><br></td></tr>';
		$this->rutaGrafico .='<tr align="center"><td>' . $this->referencia . '</table></td></tr>';
		
		return $this->rutaGrafico;
		
	}
}

class detallePorAnio extends Estadistica {
	var $subQuery = 'SELECT count(idtrat) as cant, 
							extract(year from fechaini) as ano,
							tipolic
					 from habagp.fichatratamientos
					 group by ano, tipolic
					 order by ano';
	
	function detallePorAnio(){
		$this->titulo = 'Licencias por a�o';
		$this->rutaGrafico = '<tr align="center"><td><div class="tituloGrafico">Licencias por a&ntilde;o</div><img src="../../graficos/graphpastel.php?';
		$this->query = 'SELECT cant, ano, tipolic from (' . $this->subQuery . ') as foo';
	
		parent::Estadistica();
	}
	
	function generar(){
		$this->query .= " WHERE ano between " . $this->inicio . " AND " . $this->final;
		
		$this->bd->conectar();
		$this->bd->consultar($this->query);
		if ($this->bd->estado){
			$resultado = pg_fetch_assoc($this->bd->datos);
			$this->datos = 'dat=' . $resultado['cant'];
			
			$this->referencia = '<table cellspacing="0" border="1" style="width:100%"><tr class="cabeceraTabla" align="center"><td align="center">Ref.</td><td align="center">A&ntilde;o</td><td align="center">Cantidad de licencias</td></tr>';
			$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['ano'] . '</td><td>' . $resultado['cant'] . ' licencias</td></tr>';
			
			while ($resultado = pg_fetch_assoc($this->bd->datos)){
				$this->constante += 3;
				$this->datos .= ',' . $resultado['cant'];
				$this->referencia .= '<tr align="center"><td><img src="graficos/graphref.php?ref=' . $this->constante . '&typ=1&dim=5&bkg=FFFFFF"></td><td>' . $resultado['ano'] . '</td><td>' . $resultado['cant'] . ' licencias</td></tr>';
			}

		}
		
		$this->bd->cerrarConexion();
		
		$this->rutaGrafico .= $this->datos . '&bkg=FFFFFF&ttl="" ><br></td></tr>';
		$this->rutaGrafico .='<tr align="center"><td>' . $this->referencia . '</table></td></tr>';
		
		return $this->rutaGrafico;
		
	}
}