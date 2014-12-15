<?php
class bdConfig {
	//var $host = '10.10.0.163'; //testing
	var $host = '10.10.0.174'; //desa
	var $port = '5432';
	var $user = 'postgres';
	var $password = 'postgres';
	var $dbName = 'habagp';

	function bdConfig( ) {
	}

	function connectionString(){
		return "pgsql:host=" . $this->host . " port=" . $this->port . " user=" . $this->user . " password=" . $this->password . " dbname=" . $this->dbName;
	}
}
