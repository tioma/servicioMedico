<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 27/11/14
 * Time: 12:09
 */

include_once 'objects/TipoLicencia.php';
include_once 'util.php';

$data = get_post();

switch($data){
	case 'MA':
		$tipoLicencia = new Maternidad();
		break;
	case 'A17S':
		$tipoLicencia = new Art17SinGoce();
		break;
	case 'A17G':
		$tipoLicencia = new Art17ConGoce();
		break;
	case 'ACC':
		$tipoLicencia = new Accidente();
		break;
	case 'CT':
		$tipoLicencia = new CortoTratamiento();
		break;
	case 'LT':
		$tipoLicencia = new LargoTratamiento();
		break;
	case 'SL':
		$tipoLicencia = new SinLicencia();
		break;
}

send_response($tipoLicencia);