<?php defined('BASEPATH') or exit('No direct script access allowed');
//version 20221213 force tlsv1.2 & refine the error detection
//version 20220818 support php8
//若php版本未含  curl 功能,請安裝 php-curl 套件或升級 php
class Call_api
{
	public function __construct()
	{
	}

	function callAPI($method, $url, $data)
	{
		// $key = 'KUANGLIP';
		// $X_TOKEN = $this->encryptStr('mei-fresh', $key);

		$curl = curl_init();
		switch ($method) {
			case "GET":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			// 'Content-Type: application/x-www-form-urlencoded',
			// 'X-Token: '.$X_TOKEN,
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// EXECUTE:
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
}
