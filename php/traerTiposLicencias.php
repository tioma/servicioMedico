<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 14/11/14
 * Time: 11:05
 */

include_once 'util.php';
include_once 'objects/busquedas.php';

$busqueda = new tiposDeLicencias();

send_response($busqueda->traerResultados());