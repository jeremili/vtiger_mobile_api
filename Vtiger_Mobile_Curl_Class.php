<?php
/***********************************************************************************
* Vtiger Extension for mobile webservice access using curl
* Version: 1.0
************************************************************************************/

class Vtiger_Mobile_Curl_Class {
	var $endpoint_url;
	var $user_id;
	var $user_name; // login
	var $user_key; // password
	var $token;
	var $curl_handler;
	
	var $defaults = array(
			CURLOPT_HEADER => 0,
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

	function login() {
		$curl_handler = curl_init();
		
		$params = array("_operation" => "login", "username" => $this->user_name, "password" => $this->user_key);
		$options = array(CURLOPT_URL => $this->endpointUrl, CURLOPT_POST => 1, CURLOPT_POSTFIELDS => http_build_query($params));
		curl_setopt_array($curl_handler, ($this->defaults + $options));
		$result = curl_exec($curl_handler);
		if (!$result) {
			die(curl_error($curl_handler));
		}
		$jsonResponse = json_decode($result, true);

		if ($jsonResponse["success"] == false) {
			die("Login failed: ".$jsonResponse["error"]["message"]);
		}
		
		$this->user_id = $jsonResponse["result"]["login"]["userid"];
		$sessionId = $jsonResponse["result"]["login"]["session"];
		//save session id
		$this->token = $sessionId;
		return true;
	}

	function query($query, $module) {
		$curl_handler = curl_init();
		$params = array("_operation" => "query", "_session" => $this->token, "query" => $query, "module" => $module);
		$options = array(CURLOPT_URL => $this->endpointUrl, CURLOPT_POST => 1, CURLOPT_POSTFIELDS => http_build_query($params));
		curl_setopt_array($curl_handler, ($this->defaults + $options));
		
		$result = curl_exec($curl_handler);
		if (!$result) {
			die(curl_error($curl_handler));
		}
		$jsonResponse = json_decode($result, true);
		if($jsonResponse["success"] == false) {
			die("Query failed: ".$jsonResponse["error"]["message"]);
		}
		//Array of retrieved objects
		$retrievedObjects = $jsonResponse["result"]["records"];
		
		return $retrievedObjects;
	}
}
?>
