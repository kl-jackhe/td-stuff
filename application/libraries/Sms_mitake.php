<?php defined('BASEPATH') or exit('No direct script access allowed');
//version 20221213 force tlsv1.2 & refine the error detection
//version 20220818 support php8
//若php版本未含  curl 功能,請安裝 php-curl 套件或升級 php
class Sms_mitake
{
	private $url;
	private $data;
	public function __construct()
	{
		// url
		$this->url = 'https://sms.mitake.com.tw/b2c/mtk/SmSend?';
		$this->url .= 'CharsetURL=UTF-8';
		// parameters
		$this->data = 'username=username';
		$this->data .= '&password=passowrd';
		$this->data .= '&dstaddr=0900000000';
		$this->data .= '&smbody=簡訊SmSend測試';
	}

	function send_message()
	{
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => $this->data
			)
		);

		echo '<pre>';
		print_r($options);
		echo '</pre>';

		$context = stream_context_create($options);
		$output = @file_get_contents($this->url, false, $context);

		if (!empty($output)) {
			echo '<pre>';
			print_r($output);
			echo '</pre>';
		} else {
			echo 'none';
		}
	}

	function send_cul_message()
	{
		$curl = curl_init();
		// url
		$url = 'https://sms.mitake.com.tw/b2c/mtk/SmSend?';
		$url .= 'username=0912962950';
		$url .= '&password=kai53972833';
		$url .= '&Encoding_PostIn=UTF-8';

		// parameters
		$data = '001$$0973221508$$20240322182300$$20240322182300$$$$$$簡訊SmBulkSend測試' . "\r\n";


		// 設定curl網址
		curl_setopt($curl, CURLOPT_URL, $url);
		// 設定Header
		curl_setopt(
			$curl,
			CURLOPT_HTTPHEADER,
			array("Content-type: application/x-www-form-urlencoded")
		);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		// 執行
		$output = curl_exec($curl);
		curl_close($curl);
		echo $output;
	}
}
