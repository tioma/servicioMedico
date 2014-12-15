<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 20/11/14
 * Time: 12:42
 */

include_once 'objects/Tratamiento.php';
include_once 'util.php';

$data = get_post();

$idTrat = $data['idtrat'];

$tratamiento = new Tratamiento();
$tratamiento->porId($idTrat);

send_response($tratamiento->puedoEliminar());