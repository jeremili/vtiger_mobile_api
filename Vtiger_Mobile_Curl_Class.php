<?php
/***********************************************************************************
* Vtiger Extension for mobile webservice access using curl
* Version: 1.0
************************************************************************************/

class Vtiger_Mobile_Curl_Class {
	var $endpoint_url;
	var $user_id;
	var $user_name;
	var $user_key;
	var $token;
	var $curl_handler;
	
	var $defaults = array(
			CURLOPT_HEADER => 0,
			// CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => false,	// ssl fix
			CURLOPT_SSL_VERIFYHOST => false	// ssl fix
		);
	
	//constructor saves the values
	function __construct($url, $name, $key) {
		$this->endpoint_url = $url;
		$this->user_id = 0;
		$this->user_name = $name;
		$this->user_key = $key;
		$this->token = 0;
	}
}
?>