<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 21/11/14
 * Time: 13:13
 */

include_once 'objects/busquedas.php';
include_once 'util.php';

$busqueda = new buscarPersona();

send_response($busqueda->traerResultados());