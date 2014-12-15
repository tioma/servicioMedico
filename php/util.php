<?php
/**
 * Created by PhpStorm.
 * User: artiom
 * Date: 12/11/14
 * Time: 16:17
 */

function get_post(){
	return json_decode(file_get_contents('php://input'), true);
}

function send_response($data){
	echo json_encode($data);
}