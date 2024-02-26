<?php defined('BASEPATH') or exit('No direct script access allowed');
//version 20221213 force tlsv1.2 & refine the error detection
//version 20220818 support php8
//若php版本未含  curl 功能,請安裝 php-curl 套件或升級 php
class Sms
{
	var $smsHost;
	var $sendSMSUrl;
	var $getCreditUrl;
	var $batchID;
	var $credit;
	var $processMsg;

	public function __construct()
	{
		$this->SMSHttp();
	}

	function SMSHttp()
	{
		$this->smsHost = "api.e8d.tw";
		$this->sendSMSUrl = "https://" . $this->smsHost . "/API21/HTTP/sendSMS.ashx";
		$this->sendMMSUrl = "https://" . $this->smsHost . "/API21/HTTP/MMS/sendMMS.ashx";
		$this->getCreditUrl = "https://" . $this->smsHost . "/API21/HTTP/getCredit.ashx";
		$this->batchID = "";
		$this->credit = 0.0;
		$this->processMsg = "";
	}

	/// <summary>
	/// 取得帳號餘額
	/// </summary>
	/// <param name="userID">帳號</param>
	/// <param name="password">密碼</param>
	/// <returns>true:取得成功；false:取得失敗</returns>
	function getCredit($userID, $password)
	{
		$success = false;
		$postArr["UID"] 	= $userID;
		$postArr["PWD"]		= $password;
		$resultString = $this->httpPost($this->getCreditUrl, $postArr);
		if ((substr($resultString, 0, 1) == "-") || (strlen($resultString) <= 1)) {
			$this->processMsg = $resultString;
		} else {
			$success = true;
			$this->credit = $resultString;
		}
		return $success;
	}

	/// <summary>
	/// 傳送簡訊
	/// </summary>
	/// <param name="userID">帳號</param>
	/// <param name="password">密碼</param>
	/// <param name="subject">簡訊主旨，主旨不會隨著簡訊內容發送出去。用以註記本次發送之用途。可傳入空字串。</param>
	/// <param name="content">簡訊發送內容(不需要進行urlencode)</param>
	/// <param name="mobile">接收人之手機號碼。格式為: +886912345678或09123456789。多筆接收人時，請以半形逗點隔開( , )，如0912345678,0922333444。</param>
	/// <param name="sendTime">簡訊預定發送時間。-立即發送：請傳入空字串。-預約發送：請傳入預計發送時間，若傳送時間小於系統接單時間，將不予傳送。格式為YYYYMMDDhhmnss；例如:預約2009/01/31 15:30:00發送，則傳入20090131153000。若傳遞時間已逾現在之時間，將立即發送。</param>
	/// <returns>true:傳送成功；false:傳送失敗</returns>
	function sendSMS($userID, $password, $subject, $content, $mobile, $sendTime)
	{
		$success = false;
		$postArr["UID"] 	= $userID;
		$postArr["PWD"]		= $password;
		$postArr["SB"]		= $subject;
		$postArr["MSG"]		= $content;
		$postArr["DEST"]	= $mobile;
		$postArr["ST"]		= $sendTime;
		$resultString = $this->httpPost($this->sendSMSUrl, $postArr);
		if ((substr($resultString, 0, 1) == "-") || (strlen($resultString) <= 1)) {
			$this->processMsg = $resultString;
		} else {
			$success = true;
			$strArray = explode(",", $resultString);
			$this->credit = $strArray[0];
			$this->batchID = $strArray[4];
		}
		return $success;
	}

	/// <summary>
	/// 傳送多媒體簡訊(MMS)
	/// </summary>
	/// <param name="userID">帳號</param>
	/// <param name="password">密碼</param>
	/// <param name="subject">MMS主旨,必填。</param>
	/// <param name="content">簡訊發送內容(不需要進行urlencode)</param>
	/// <param name="mobile">接收人之手機號碼。格式為: +886912345678或09123456789。多筆接收人時，請以半形逗點隔開( , )，如0912345678,0922333444。</param>
	/// <param name="type">圖檔附檔名,支援png, jpg, jpeg, gif 格式</param>
	/// <param name="attachment">圖檔內容,必需為  base64格式 (可使用 base84_encode)</param>
	/// <param name="sendTime">簡訊預定發送時間。-立即發送：請傳入空字串。-預約發送：請傳入預計發送時間，若傳送時間小於系統接單時間，將不予傳送。格式為YYYYMMDDhhmnss；例如:預約2009/01/31 15:30:00發送，則傳入20090131153000。若傳遞時間已逾現在之時間，將立即發送。</param>
	/// <returns>true:傳送成功；false:傳送失敗</returns>
	function sendMMS($userID, $password, $subject, $content, $attachment, $type, $mobile, $sendTime)
	{
		$success = false;
		$postArr["UID"] 	= $userID;
		$postArr["PWD"]		= $password;
		$postArr["SB"]		= $subject;
		$postArr["MSG"]		= $content;
		$postArr["DEST"]	= $mobile;
		$postArr["ST"]		= $sendTime;
		$postArr["TYPE"]	= $type;
		$postArr["ATTACHMENT"] = $attachment;
		$resultString = $this->httpPost($this->sendMMSUrl, $postArr);
		if ((substr($resultString, 0, 1) == "-") || (strlen($resultString) <= 1)) {
			$this->processMsg = $resultString;
		} else {
			$success = true;
			$strArray = explode(",", $resultString);
			$this->credit = $strArray[0];
			$this->batchID = $strArray[4];
		}
		return $success;
	}


	//若php版本過低未含  curl 功能,請安裝 curl 套件或升級 php
	function httpPost($url, $postArray)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSLVERSION, 6);  //Force requsts to use TLS 1.2
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postArray));
		$res = curl_exec($curl);
		if ($res === false) {
			return "-1000: " . curl_error($curl);
		}
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($http_status != 200) return "-2000: http status code: " . $http_status;
		$strArray = explode("\r\n\r\n", $res);
		$idx = count($strArray) - 1;
		if (!isset($strArray[$idx])) return "-" . $errno . ":$errstr \nRESPONSE:\"" . $res . "\"";
		return $strArray[$idx];
	}
}
