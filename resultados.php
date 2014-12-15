<?php

include_once 'busquedas.php';

$tipobusqueda = $_REQUEST['par'];
$limite = 150;

$tratamiento = new buscarTratamiento();
$evolucion = new buscarEvolucion();
$enfermedad = new buscarEnfermedad();
$persona = new buscarPersona();
$licencias = new buscarLicenciasAcumuladas();
$licenciasOtras = new buscarOtrasLicencias();

switch ($tipobusqueda){
	case "nombre":
		$tratamiento->porNombre($_REQUEST['valor']);	
		break;
	case "enfermedad":
		$tratamiento->porEnfermedad($_REQUEST['valor']);
		break;
	case "inicio":
		$tratamiento->porInicio($_REQUEST['valor']);
		break;
	case "alta":
		$tratamiento->porAlta($_REQUEST['valor']);
		break;
	case "nada":
		$tratamiento->sinFiltros();
		break;
	case "codigoEnf":
		if (isset($_REQUEST['valor']) && $_REQUEST['valor'] != '') { $enfermedad->filtrar(strtoupper($_REQUEST['valor'])); }
		echo $enfermedad->traerResultados();
		exit;
		break;
	case "codigoEnf2":
		if (isset($_REQUEST['valor']) && $_REQUEST['valor'] != '') { $enfermedad->filtrar(strtoupper($_REQUEST['valor'])); }
		echo $enfermedad->traerResultados2();
		exit;
		break;
	case "codigoEnf3":
		if (isset($_REQUEST['valor']) && $_REQUEST['valor'] != '') { $enfermedad->filtrar(strtoupper($_REQUEST['valor'])); }
		echo $enfermedad->traerResultados3();
		exit;
		break;
	case "codigoEnfSinFiltro":
		echo $enfermedad->traerResultados();
		exit;
		break;
	case "evolucion":
		echo $evolucion->evolucionTratamiento($_REQUEST['valor']);
		exit;
		break;
	case "persona":
		echo $persona->traerResultados(strtoupper($_REQUEST['valor']));
		exit;
		break;
	case "licenciasAcumuladas":
		if (isset($_REQUEST['valor']) && $_REQUEST['valor'] != '') { $licencias->porLegajo($_REQUEST['valor']); }
		echo $licencias->traerResultados();
		exit;
		break;
	case "licenciasAcumuladasFiltro":
		$licencias->porLegajo($_REQUEST['valor']);
		echo $licencias->traerResultados();
		exit;
		break;
	case "otrasLicencias":
		if (isset($_REQUEST['valor']) && $_REQUEST['valor'] != '') { $licenciasOtras->porLegajo($_REQUEST['valor']); }
		echo $licenciasOtras->traerResultados();
		exit;
		break;
	case "otrasLicenciasFiltro":
		$licenciasOtras->porLegajo($_REQUEST['valor']);
		echo $licenciasOtras->traerResultados();
		exit;
		break;
	case "diasRestantes":
		$licencias->porDiasRestantes($_REQUEST['valor']);
		echo $licencias->traerResultados();
		exit;
		break;
}

$filtro = $_REQUEST['filtro'];

switch ($filtro) {
	case "Alta":
		$tratamiento->soloAltas();
		break;
	case "Curso":
		$tratamiento->soloEnCurso();
		break;
}

switch ($tipobusqueda){
	case "nombre":
		$tratamiento->conOrdenYLimite("fechaini", $limite);	
		break;
	case "enfermedad":
		$tratamiento->conOrdenYLimite("enfermedad", $limite);
		break;
	case "inicio":
		$tratamiento->conOrdenYLimite("fechaini", $limite);
		break;
	case "alta":
		$tratamiento->conOrdenYLimite("fechaalta", $limite);
		break;
	case "nada":
		$tratamiento->conOrdenYLimite("fechaini", $limite);
		break;
}

echo $tratamiento->traerResultados();
?>
